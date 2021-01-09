package com.dhbw.config;

import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

import com.dhbw.fungarium.components.Ventilation;

// Daten die der Benutzer über die PHP-Steuerseite vorgeben kann
// Hier mit dem Namen RulesData (Einstellparameter), da mit diesen Daten die Checks durchgeführt werden 
public class RulesData {

	private final static Logger lg = LogManager.getLogger(RulesData.class);
	
	public RulesData() {						// Konstruktor mit den default Werten
		this.tempMax = 27;						// Die default Werte bleiben bestehen, bis von der Datenbank 
		this.tempMin = 15;						// ein Wert eingelesen wird der in der geforderten Range liegt
		this.humMin = 80;
		this.humTime = 15;
		this.lightHourOn = 8;
		this.lightMinuteOn = 30;
		this.lightHourOff = 21;
		this.lightMinuteOff = 30;
		this.ventilationTime = 10;
		this.timestamp = System.currentTimeMillis();
	}

	public int tempMax; // in °C
	public int tempMin; // in °C
	public int humMin; // in %
	public int humTime; // in minutes
	public int ventilationTime; // in minutes
	public int lightHourOn;	
	public int lightHourOff;
	public int lightMinuteOn;
	public int lightMinuteOff;
	private boolean lightRangeInverse;
	private long timestamp;

	// Getter und Setter Methoden
	// In den Setter Methoden wird gleich gecheckt, ob der eingelesene Wert in der geforderten Range liegt -> Plausibilitätsprüfung
	// Bei nicht bestehen der Plausibilitätsprüfung wird der Wert nicht verändert und somit der alte Wert beibehalten 
	public int getTempMax() {
		return tempMax;
	}

	public void setTempMax(int tempMax) {
		if (tempMax <= 35 && tempMax >= 15 && (tempMax - this.tempMin) > 5) 
			this.tempMax = tempMax;
		else if ((tempMax - this.tempMin) < 5)
			this.tempMax = this.tempMin + 5;
		else lg.error("Die eingegebene Höchsttemperatur liegt nicht im vorgegebenen Bereich! Daher wird der alte Wert beibehalten");
	}

	public int getTempMin() {
		return tempMin;
	}

	public void setTempMin(int tempMin) {
		if (tempMin <= 25 && tempMin >= 0)
			this.tempMin = tempMin;
		else lg.error("Die eingegebene Mindesttemperatur liegt nicht im vorgegebenen Bereich! Daher wird der alte Wert beibehalten");
	}

	public int getHumMin() {
		return humMin;
	}

	public void setHumMin(int humMin) {
		if (humMin <= 100 && humMin >= 50)
			this.humMin = humMin;
		else lg.error("Die eingegebene Mindestfeuchtigkeit liegt nicht im vorgegebenen Bereich! Daher wird der alte Wert beibehalten");
	}
	
	public void setTimeStart(int hour, int minute) {
		// Überprüfung ob TimeStart und TimeEnd gleich sind
		if (!(hour == this.lightHourOff && minute == this.lightMinuteOff)) {
			this.lightHourOn = hour;
			this.lightMinuteOn = minute;
		}
		
		_checkLightRange();
	}

	public void setTimeEnd(int hour, int minute) {
		// Überprüfung ob TimeStart und TimeEnd gleich sind
		if (!(hour == this.lightHourOn && minute == this.lightMinuteOn)) {
			this.lightHourOff = hour;
			this.lightMinuteOff = minute;
		}
		
		_checkLightRange();
	}
	
	public Calendar getLightOnDate()
	{
		Calendar lightOnDate = new GregorianCalendar();
		lightOnDate.set(Calendar.HOUR_OF_DAY,lightHourOn);
		lightOnDate.set(Calendar.MINUTE,lightMinuteOn);
		return lightOnDate;
	}
	
	public Calendar getLightOffDate()
	{
		Calendar lightOffDate = new GregorianCalendar();
		lightOffDate.set(Calendar.HOUR_OF_DAY,lightHourOff);
		lightOffDate.set(Calendar.MINUTE,lightMinuteOff);
		
		// Hier wird überprüft ob lightRangeInverse = true ist. Ist dies der Fall wird ein Tag zum lightOffDate addiert.
		// Dadurch ist es möglich das Licht des Fungariums auch über Nacht anzuschalten. Beispielsweise von 22:00 - 4:00 Uhr
		if (lightRangeInverse)
			lightOffDate.add(Calendar.DAY_OF_YEAR, 1);
		return lightOffDate;
	} 
	
	public int getVentilationTime() {
		return ventilationTime;
	}

	public void setVentilationTime(int ventilationTime) {
		if (ventilationTime <= 30 && ventilationTime >= 5)
			this.ventilationTime = ventilationTime;
		else lg.error("Die eingegebene Lüftungsdauer liegt nicht im vorgegebenen Bereich! Daher wird der alte Wert beibehalten");
	}

	public int getHumTime() {
		return humTime;
	}

	public void setHumTime(int humTime) {
		if (humTime <= 30 && humTime >= 5)
			this.humTime = humTime;
		else lg.error("Die eingegebene Mindesttemperatur liegt nicht im vorgegebenen Bereich! Daher wird der alte Wert beibehalten");
	}

	@Override
	public String toString() {
		return "[" + tempMax + "°C, " + tempMin + "°C, " + humMin + "%, " + humTime
				+ "min, light on: " + this.lightHourOn + ":" + this.lightMinuteOn + ", light off: " + this.lightHourOff + ":" 
				+ this.lightMinuteOff + " Uhr, " + ventilationTime + "min]";
	}
	
	// Die Methode überprüft ob TimeEnd kleiner ist als TimeStart
	private void _checkLightRange()
	{
		if (lightHourOff < lightHourOn)
		{
			lightRangeInverse = true;
		}			
	}

	public boolean isLightRangeInverse() {
		return lightRangeInverse;
	}
}
