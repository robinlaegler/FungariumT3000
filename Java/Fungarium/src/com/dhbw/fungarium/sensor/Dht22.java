package com.dhbw.fungarium.sensor;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.Hashtable;
import java.util.Timer;
import java.util.TimerTask;
import java.util.concurrent.BlockingQueue;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

import com.dhbw.config.GCT;
import com.dhbw.fungarium.components.Actor;
import com.dhbw.fungarium.components.GPIO_Channel;
import com.dhbw.fungarium.components.Light;
import com.pi4j.wiringpi.Gpio;

public class Dht22 extends Thread {
	private final static Logger lg = LogManager.getLogger(Dht22.class);
	
	public Dht22(String sensorLocation, BlockingQueue<SensorData> sensorDataQueue) {
		
		this(sensorLocation,sensorDataQueue,120); 				// Instanziieren mit einem default Zyklus
		this.gct=GCT.getInstance();
	}

	public Dht22(String sensorLocation, BlockingQueue<SensorData> sensorDataQueue, int meterPeriod) {
		super();
		this.meterPeriod = meterPeriod;
		this.sensorDataQueue = sensorDataQueue;
		this.sensorLocation = sensorLocation;
		this.gct=GCT.getInstance();
	}
	
	private String sensorLocation;
    private BlockingQueue<SensorData> sensorDataQueue;
	private int meterPeriod; 						// in seconds
	private boolean stop;
	private GCT gct;
    private boolean sensorStatus;
   
	@Override
	public void run() {
		
		doMeter();
		while (!this.stop) {
			
				if (!this.gct.isEmergency()) {	// Messung im Normalbetrieb
					try {
						Thread.sleep(this.meterPeriod * 1000*60);	// meterPeriod in Minutes
					} catch (InterruptedException e) {
						System.out.println("Interruptexceotion received");
					}
					doMeter();
				}
			
				else if (this.gct.isEmergency()) { // Messung im Notbetrieb
					try {
						Thread.sleep(1000*60*60);
					} catch (InterruptedException e) {
						System.out.println("Interruptexceotion received");
					}
					doMeter();
				}
				
				synchronized (this) {
					try {	
						wait(); // Hier "wartet" der Sensor, bis im Hauptprogramm die Checks durchgeführt wurden
					} catch (InterruptedException e) {
						e.printStackTrace();
					}
				}
		}

	lg.error("Der Sensor wurde gestoppt.");	
	}
	
	// Getter und Setter Methoden
	public int getMeterPeriod() {
		return meterPeriod;
	}

	public void setMeterPeriod(int meterPeriod) {
		this.meterPeriod = meterPeriod;
	}
	
	public void setStop() {
		this.stop = true;
	}

	public void doMeter() {
		
		// Überprüfung, ob der Sensor sich im Neustart befindet
		if (!this.sensorStatus) {							
			lg.info("Sensordaten werden vom DHT22 gelesen.");
			
			
			// Einlesen der Daten über den DHT11
			// Hier auskommentiert zu Testzwecken
			/*
			Hashtable<String, Float> temp_hum = new Hashtable<String,Float>();
		    try {
				temp_hum = readSensorData();
			} catch (IOException e) {
				e.printStackTrace();
			}*/
			
			
			
			// SensorData Wert erstellen mit Ort/Luftfeuchtigkeit/Temperatur zu Testzwecken
			// Luftfeuchtigkeit und Temperatur werden über das Properties File vorgegeben
			SensorData sd = new SensorData(this.sensorLocation, gct.getHum() , gct.getTemp() );		
			
			// Normaler Code an dieser Stelle
			// SensorData sd = new SensorData(this.sensorLocation, temp_hum.get("humidity") , temp_hum.get("humidity") );	
			
			//Sensordaten werden zur Queue hinzugefügt
			this.sensorDataQueue.add(sd);
		}
	}
	
	//Methode, die die aktuelle Temperatur und Luftfeuchtigkeit über den DHT22 ausliest
    private static Hashtable readSensorData() throws IOException{
        
        // creating a HashTable Dictionary
        Hashtable<String, Float> temp_hum = new Hashtable<String, Float>();
        
        // command to execute and get dht data								
        String[] commands = {"sudo", "python3", "mydht.py", "11", "4"};		// mydht.py ist der Dateiname des Python Scripts
        Runtime rt = Runtime.getRuntime();									// 11 --> wegen DHT11, 4 --> der entsprechende GPIO Pin
       // Die Klasse Runtime ermöglicht die Interaktion eines Java-Programmes mit dem Bestandteil seiner Laufzeitumgebung
        
        try{
	        Process proc = rt.exec(commands);	// Aufrufen des Python Skripts zum Einlesen der Sensordaten
	
	        BufferedReader stdInput = new BufferedReader(new 
	             InputStreamReader(proc.getInputStream()));
	
	        BufferedReader stdError = new BufferedReader(new 
	             InputStreamReader(proc.getErrorStream()));
	
	        // Read the output from the command
	        String s = null;
	        while ((s = stdInput.readLine()) != null) {
	            String[] vals = s.split(" ");
	            float t = Float.parseFloat(vals[0].trim());			
	            float h = Float.parseFloat(vals[1].trim());			
	            temp_hum.put("temperature", t);
	            temp_hum.put("humidity", h);
	        }
	        // Read any errors from the attempted command
	        while ((s = stdError.readLine()) != null) {
	            System.out.println(s);
	        }
	    }
	    catch(IOException ex) {
	        System.out.println(ex.toString());
	    }
	    return temp_hum;
    }
	
	public void sensorRestart() {			
		
		sensorStatus = true; // Setzten des Sensorstatus, sodass kein Messung angestoßen werden, während der Sensor ausgeschalten ist  
		lg.info("Sensor wird neugestarte.");
		new Actor (GPIO_Channel.DHT22,LogManager.getLogger(Dht22.class)).off();
		
		// Überprüfen ob im Normalbetrieb oder im Notbetrieb
		if (!this.gct.isEmergency()) {							// Sensor Neustart im Normalbetrieb (alle 24h)
			Timer timer =new Timer();										
			timer.schedule(new TimerTask() {
				@Override
				public void run() {
					new Actor (GPIO_Channel.DHT22,LogManager.getLogger(Dht22.class)).on();
					sensorStatus=false;
					doMeter();									// Hier sollte vielleicht nochmal gewartet werden bis der Sensor wirklich eingeschalten ist
					timer.cancel();
				}
			}, 1000*10);					
			
		}			
		else {													// Sensor Neustart im Notbetrieb 
			Timer timer =new Timer();
			lg.info("Sensorneustart im Notbetrieb");
			timer.schedule(new TimerTask() {
				@Override
				public void run() {			
					new Actor (GPIO_Channel.DHT22,LogManager.getLogger(Dht22.class)).on();
					sensorStatus =false;
					doMeter();									// Hier sollte vielleicht nochmal gewartet werden bis der Sensor wirklich eingeschalten ist
					timer.cancel();
				}
				
			}, 1000*10);
		}	
	}

}
