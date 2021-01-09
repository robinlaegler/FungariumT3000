package com.dhbw.config;

import java.sql.Connection;

//Singletton-Pattern
public class GCT {
	private final static String VERSION = "0.9.0";

	private GCT() {
		super();
		this.rulesData = new RulesData(); 
	}

	private static GCT instance;

	//Testparameter --> Sensordaten! Diese können im Propeties File gesetzt werden
	private int temp;
	private int hum;
	
	// Zustandsparameter
	private boolean emergency;
	private boolean ventilation;
	private boolean heater;
	private boolean cooling;
	private boolean Light;

	// Rules data
	private RulesData rulesData;

	// DB Connection
	private String dbHostname = "localhost";
	private String dbPort = "3306";
	private String dbName = "test";
	private String dbUser = "root";
	private String dbPassword = "";
	private Connection connection;

	//Zugriff auf das Objekt des GCT
	public static GCT getInstance() {
		if (instance == null)
			instance = new GCT();

		return instance;
	}
	
	//Getter und Setter Methoden 
	public String getDbHostname() {
		return dbHostname;
	}

	public void setDbHostname(String dbHostname) {
		this.dbHostname = dbHostname;
	}

	public String getDbPort() {
		return dbPort;
	}

	public void setDbPort(String dbPort) {
		this.dbPort = dbPort;
	}

	public String getDbName() {
		return dbName;
	}

	public void setDbName(String dbName) {
		this.dbName = dbName;
	}

	public String getDbUser() {
		return dbUser;
	}

	public void setDbUser(String dbUser) {
		this.dbUser = dbUser;
	}

	public String getDbPassword() {
		return dbPassword;
	}

	public void setDbPassword(String dbPassword) {
		this.dbPassword = dbPassword;
	}

	public static String getVersion() {
		return VERSION;
	}

	public RulesData getRulesData() {
		return rulesData;
	}

	public void setRulesData(RulesData rulesData) {
		this.rulesData = rulesData;
	}

	public boolean isEmergency() {
		return emergency;
	}

	public void setEmergency(boolean emergency) {
		this.emergency = emergency;
	}

	public boolean isVentilation() {
		return ventilation;
	}

	public void setVentilation(boolean ventilation) {
		this.ventilation = ventilation;
	}

	public Connection getConnection() {
		return connection;
	}

	public void setConnection(Connection connection) {
		this.connection = connection;
	}

	public boolean isHeater() {
		return heater;
	}

	public void setHeater(boolean heater) {
		this.heater = heater;
	}

	public boolean isCooling() {
		return cooling;
	}

	public void setCooling(boolean cooling) {
		this.cooling = cooling;
	}

	public boolean isLight() {
		return Light;
	}

	public void setLight(boolean light) {
		Light = light;
	}

	public int getTemp() {
		return temp;
	}

	public void setTemp(int temp) {
		this.temp = temp;
	}

	public int getHum() {
		return hum;
	}

	public void setHum(int hum) {
		this.hum = hum;
	}


}
