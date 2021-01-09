package com.dhbw.fungarium;

import java.sql.Connection;
import java.sql.DriverManager;
import java.util.Date;
import java.util.Timer;
import java.util.TimerTask;
import java.util.concurrent.ArrayBlockingQueue;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

import com.dhbw.config.GCT;
import com.dhbw.fungarium.components.Actor;
import com.dhbw.fungarium.components.Cooling;
import com.dhbw.fungarium.components.Fan;
import com.dhbw.fungarium.components.Fogger;
import com.dhbw.fungarium.components.GPIO_Channel;
import com.dhbw.fungarium.components.Heater;
import com.dhbw.fungarium.components.Light;
import com.dhbw.fungarium.components.Ventilation;
import com.dhbw.fungarium.sensor.Dht22;
import com.dhbw.fungarium.sensor.SensorData;

public class Fungarium {
	// Instanzieren des Loggers
	final static Logger lg = LogManager.getLogger(Fungarium.class);
	private GCT gct;
	
	public Fungarium() {
		super();
		this.gct = GCT.getInstance();
	}

	public void doFungarium() {
		lg.info("Starting Fungarium version {}", GCT.getVersion());
		
		// Erstellen der Verbindung zur Datenbank
		gct.setConnection(connectToMysql(gct.getDbHostname(),gct.getDbPort(),gct.getDbName(),gct.getDbUser(),gct.getDbPassword()));
		
		// Instanzieren der SensorDataQueue
		ArrayBlockingQueue<SensorData> sensorDataQueue = new ArrayBlockingQueue<SensorData>(100);
		
		// Instanzieren eines Timers der in Zeitabständen von 10 Sekunden die Methode checkLight() der Klasse Light aufruft 
		// Damit kann das Licht 10 Sekundenweise ein- und aussgeschalten werden
		Timer timer = new Timer();
		TimerTask tt = new TimerTask() {
			@Override
			public void run() {
				gct.setRulesData(new RulesDataHandler().read()); // Vor der Überprüfung werden die aktuellen Einstellparameter einlesen
				new Light().checkLight(); // Überprüfen ob das Licht an oder ausgeschalten werden muss
			}
		};
		timer.schedule(tt, 0, 1000*10); // Zeiteinstellung des Timers --> hier: 1 Minute 
		
		//Anschalten GPIO-Pin des Sensors
		new Actor(GPIO_Channel.DHT22,LogManager.getLogger(Dht22.class)).on();
		
		// Instanzieren und Starten des Sensor Threads
		Dht22 dht22Sensor = new Dht22("Fungarium", sensorDataQueue, 2); // (sensorlocation, Dataqueue, Meterperiod in Minuten)																 
		dht22Sensor.start();

		// Instanzieren eines Timers, welcher alle 24 Stunden den DHT22 neu startet
		Timer sensorRestartTimer = new Timer();
		TimerTask oneDay = new TimerTask() {
			@Override
			public void run() {
				dht22Sensor.sensorRestart();
			}
		};
		sensorRestartTimer.schedule(oneDay, getDateDiff(new Date(), new Date()), 1000 * 60 * 60 * 24); 
		// Durch Anwendung der Methode getDateDiff wird geschaut, das der Sensorneustart immer um 24 Uhr stattfindet

		SensorData sd = null;
		int emer = 0;
		
		while (true) {

			try {
				// Hier wartet der "Fungarium" main thread bis ein Sensor aktuelle Sensor Daten
				// in die SensorDateQueue schreibt.
				sd = sensorDataQueue.take();
			} catch (InterruptedException e) {
				lg.error("Fehler beim Warten auf neue Sensorwerte");
			}
			
			lg.info("Die aktuellen RulesData: {}",gct.getRulesData());
			if (!plausibilitycheck(sd)) { // 1. Check ob die vom Sensor aufgenommenen Sensordaten korrekt sind
				lg.error("Die Sensordaten sind nicht korrekt: {}",sd);
				
				if (emer < 3) {
					turnChannels_off(); // Schaltet die Akoren aus
					gct.setEmergency(true); // Das System wird in Notberieb versetzt
					emer++;
					dht22Sensor.sensorRestart(); // Sensor wird neugestartet
				} else {
					//dht22Sensor.setStop(); Der Sensor wird in Folge von drei falschen Messungen gestoppt
					synchronized (dht22Sensor) {
						dht22Sensor.notify();
					}
				}
			} 
			else {
				lg.info("Sensordaten: {}",sd);
				emer=0;
				gct.setEmergency(false);
				writeToDb(sd); // Sensordaten in die Datenbank schreiben
				checkTemperature(sd); // Temperaturzustand überprüfen
				checkHumidity(sd, dht22Sensor); // Luftfeuchtigkeit überprüfen
				synchronized (dht22Sensor) {
					dht22Sensor.notify();	// Sensor aufwecken
				}
			}
		}

	}
	
	// Aktoren ausschalten beim Umschalten in den Notbetrieb
	private void turnChannels_off() {
		if(!gct.isEmergency()) {
			lg.error("Alle Komponenten ausschalten. Wechsel in den Notbetrieb");
			new Fan().off();
			new Fogger().off();
			new Heater().off();
			new Cooling().off();
		}
	}

	// Methode, die überprüft, ob die vom Sensor aufgenommenen Daten korrekt sind 
	private boolean plausibilitycheck(SensorData sd) {
		if (sd.getHumidity() < 20 || sd.getHumidity() > 100 || sd.getTemperature() < 10 || sd.getTemperature() > 50)
			return false;
		else
			return true;
	}

	// Sensordaten in die Datenbank schreiben
	private void writeToDb(SensorData sd) {
		// toDo: Verbindung zur Datenbank steht bereits
		// Befehle zum schreiben der Daten in die Datenbank
	
	}

	private void checkTemperature(SensorData sd) {
		// Überprüfung ob es sich um Sensordaten des Fungariums handelt
		if ("fungarium".equalsIgnoreCase(sd.getSensorLocation())) {
				
			// Überprüfen ob Kühlung eingeschalten werden muss
			if (sd.getTemperature() > gct.getRulesData().getTempMax()) { 
				// Überprüfen ob die bereits an ist
				if (!gct.isCooling()) {
					new Cooling().on(); // Starten der Kühlung
					gct.setCooling(true);
				}
			} // Überprüfen ob Heizung eingeschalten werden muss
			else if (sd.getTemperature() < gct.getRulesData().getTempMin()) {
				//überprüfen ob die Heizung bereits an ist
				if (!gct.isHeater()) {
					new Heater().on(); // Starten der Kühlung
					gct.setHeater(true);
				} 
			} // Überprüfen ob Heizung wieder ausgeschalten werden kann --> Schwelle: Mindesttemperatur+(Höchsttemperatur-Mindesttemperatur)*25%
			if (sd.getTemperature() > (gct.getRulesData().getTempMin()+(gct.getRulesData().getTempMax()-gct.getRulesData().getTempMin())*0.25)) {									
				if (gct.isHeater()) {
					new Heater().off();
					gct.setHeater(false);
				}  
			} // Überprüfen ob Kühlung ausgeschalten werden kann --> Schwelle: Höchsttemperatur-(Höchsttemperatur-Mindesttemperatur)*25%
			if (sd.getTemperature() < (gct.getRulesData().getTempMax()-(gct.getRulesData().getTempMax()-gct.getRulesData().getTempMin())*0.25)) {									
				if (gct.isCooling()) {
					new Cooling().off();
					gct.setCooling(false);
				}
			}

		}
	}
	// Methode, die überprüft ob die aktuelle Luftfeuchtihkeit im vorgegeben Bereich liegt
	private void checkHumidity(SensorData sd, Dht22 dht22Sensor) { 
		// Überprüfen ob es sich um Sensordaten des Fungariums handelt
		if ("fungarium".equalsIgnoreCase(sd.getSensorLocation())) {
			if (sd.getHumidity() < gct.getRulesData().getHumMin()) {
				// Überprüfen ob die Ventilationsroutine bereits gestartet ist
				if (!gct.isVentilation()) {
					new Ventilation(dht22Sensor).start(); // Starten der Ventilationsroutine
				}

			}
		}

	}
	
	// Methode, die die Differenz zwischen der aktuellen Zeit und 24:00Uhr berechnet
	public long getDateDiff(Date date1, Date date2) {
		date2.setHours(24);
		return date2.getTime() - date1.getTime();
	}
	
	// Erstellen der Verbindung zur Datenbank
	public  Connection connectToMysql(String hostname,String port, String dbname, String user, String password){
		try{
			Class.forName("com.mysql.cj.jdbc.Driver").newInstance();			
			String connectionCommand = "jdbc:mysql://"+hostname+":"+ port +"/"+dbname;
			return DriverManager.getConnection(connectionCommand,user, password);
		}catch (Exception ex){
			lg.error("Verbindung zur Datenbank fehlgeschlagen!");
			return null;
		}
	}
}
