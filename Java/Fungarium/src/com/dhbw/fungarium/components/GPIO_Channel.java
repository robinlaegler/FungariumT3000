package com.dhbw.fungarium.components;

// Zuweisung der GPIO Pins zu den jeweiligen Relais, welche wiederum die jeweiligen Komponenten ansteuern
public enum GPIO_Channel {
	
	Fan(21, "Fan"), // Relais 1
	CH2(22), // Relais 2
	CH3(23), // Relais 3
	Light(27, "Licht"), // Relais 4
	Fogger(24, "Fogger"), // Relais 5
	DHT22(28, "Sensor DHT22"), // Relais 6
	Cooling(29, "Kühlung"), // Relais 7
	Heater(25, "Heizung"), // Relais 8
	_END_(9999);

	private GPIO_Channel(int pin, String description) {
		this.pin = pin;
		this.description = description;
	}

	private GPIO_Channel(int pin) {
		this(pin, null);
	}

	private int pin;
	private String description;

	public int getPin() {
		return pin;
	}

	public String getDescription() {
		return description;
	}

}
