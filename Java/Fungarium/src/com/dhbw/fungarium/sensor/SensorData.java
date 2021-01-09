package com.dhbw.fungarium.sensor;

import java.util.Date;

public class SensorData {
	public SensorData(String sensorLocation, float humidity, float temperature) {
		super();
		this.sensorLocation = sensorLocation;
		this.humidity = humidity;
		this.temperature = temperature;
		this.timestamp = System.currentTimeMillis();
	}
	private String sensorLocation;
	private float humidity;
	private float temperature;
	private long timestamp;
	
	public float getHumidity() {
		return humidity;
	}
	public void setHumidity(int humidity) {
		this.humidity = humidity;
	}
	public float getTemperature() {
		return temperature;
	}
	public void setTemperature(int temperature) {
		this.temperature = temperature;
	}
	
	public String getSensorLocation() {
		return sensorLocation;
	}
	
	@Override
	public String toString() {
		// TODO Auto-generated method stub
		return "[" +	sensorLocation + ", " + humidity +"% , " +  temperature + "°C]";
		//return new Date(this.timestamp) + "-" + "SensorLocation:" + this.sensorLocation + ", Temperature:" + this.temperature + " Humidity:" + this.humidity;
	}
}
