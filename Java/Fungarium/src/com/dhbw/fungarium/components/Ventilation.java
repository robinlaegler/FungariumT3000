package com.dhbw.fungarium.components;

import java.util.Date;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

import com.dhbw.config.GCT;
import com.dhbw.config.RulesData;
import com.dhbw.fungarium.sensor.Dht22;
import com.dhbw.fungarium.sensor.SensorData;

public class Ventilation extends Thread {

	private final static Logger lg = LogManager.getLogger(Ventilation.class);

	private Dht22 dht22Sensor;
	private Fan fan;
	private Fogger fogger;
	private GCT gct;

	public Ventilation(Dht22 dht22Sensor) {
		super();
		this.dht22Sensor = dht22Sensor;
		this.fan = new Fan();
		this.fogger = new Fogger();
		this.gct = GCT.getInstance();
	}

	public void run() {
		// Status setzten
		this.gct.setVentilation(true);
		lg.info("Starten der Ventilationsroutine.");
		fan.on(); // Lüfter an 
		try {
			// Hochtouriger Betrieb hier noch nicht berücksichtig
			Thread.sleep(gct.getRulesData().getVentilationTime() * 1000*60); // Ventilation Time in Minutes
			fan.off();	//Lüfter aus									  // hier gerade noch in Sekunden wegen Testzwecke
			fogger.on(); // Fogger an
			Thread.sleep(gct.getRulesData().getHumTime() * 1000*60); // Fogger Time in Minutes
			fogger.off(); // Fogger aus									  // hier gerade noch in Sekunden wegen Testzwecke
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		// Status zurücksetzten
		this.gct.setVentilation(false);
		
		// Messung anstoßen (Kontrollmessung)
		this.dht22Sensor.doMeter();

	}
}
