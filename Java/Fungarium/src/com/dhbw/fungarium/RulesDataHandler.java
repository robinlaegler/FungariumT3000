package com.dhbw.fungarium;

import java.io.IOException;
import java.util.Properties;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

import com.dhbw.config.GCT;
import com.dhbw.config.RulesData;

public class RulesDataHandler {
	private final static Logger lg = LogManager.getLogger(RulesDataHandler.class);
	private final static String RULES_PROPERTIES_FILE_NAME = "rules.properties"; 
	private GCT gct;

	public RulesDataHandler() {
		super();
		this.gct = GCT.getInstance();
	}
    
	public RulesData read()
	{
		return _readRulesFromProperties();
		//return _readRulesFromDb();
	}
	
	//Liest die RulesData aus einem properties file
	private RulesData _readRulesFromProperties() {
		lg.debug("Reading rules from properties file {} via classpath", RULES_PROPERTIES_FILE_NAME);
		RulesData rulesData = gct.getRulesData();
		Properties ruleProps = new Properties();
		try {
			ruleProps.load(this.getClass().getClassLoader().getResourceAsStream(RULES_PROPERTIES_FILE_NAME));
		} catch (IOException ioe) {
			lg.error("Error while loading rules from propeties file: {}",RULES_PROPERTIES_FILE_NAME,ioe);
		}

		if (ruleProps.get("tempMin") != null )
			rulesData.setTempMin(Integer.parseInt((String)ruleProps.get("tempMin")));
		if (ruleProps.get("tempMax") != null )
			rulesData.setTempMax(Integer.parseInt((String)ruleProps.get("tempMax")));
		if (ruleProps.get("humMin") != null )
			rulesData.setHumMin(Integer.parseInt((String)ruleProps.get("humMin")));
		if (ruleProps.get("humTime") != null )
			rulesData.setHumTime(Integer.parseInt((String)ruleProps.get("humTime")));
		if (ruleProps.get("ventilationTime") != null )
			rulesData.setVentilationTime(Integer.parseInt((String)ruleProps.get("ventilationTime")));
		if (ruleProps.get("temp") != null )
			gct.setTemp(Integer.parseInt((String)ruleProps.get("temp"))); // Nur zum Test
		if (ruleProps.get("hum") != null )
			gct.setHum(Integer.parseInt((String)ruleProps.get("hum"))); // Nur zum Test
		if (ruleProps.get("lightOnTime") != null )
		{
			String[] lightOnTime = ((String) ruleProps.get("lightOnTime")).split(":");
			rulesData.setTimeStart(Integer.parseInt(lightOnTime[0]), Integer.parseInt(lightOnTime[1]));
		}
		if (ruleProps.get("lightOffTime") != null )
		{
			String[] lightOffTime = ((String) ruleProps.get("lightOffTime")).split(":");
			rulesData.setTimeEnd(Integer.parseInt(lightOffTime[0]), Integer.parseInt(lightOffTime[1]));
		}	
		
		return rulesData;
	}
    
	private RulesData _readRulesFromDb() {
		lg.debug("Reading rules from database");
		RulesData rulesData = gct.getRulesData();
		
		//TODO: Lesen von der DB
				
		return rulesData;
	}
}
