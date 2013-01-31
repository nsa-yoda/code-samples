package com.jsanc623.batty.notifier;

import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.database.Cursor;
import android.widget.CompoundButton;
import android.widget.Toast;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.Switch;


@SuppressWarnings("unused")
public class MainActivity extends Activity {
    public DataProvider DataProvider = new DataProvider(MainActivity.this);
    public static int db_showTemp = 0;
    public static int db_showHealth = 0;
    public static int db_showVoltage = 0;
    public static int db_showVoltageMilli = 0;
    public static int db_showStatus = 0;
    public static int db_periodicToasts = 0;
    
    public void retrieveFromDb(){
    }
    
    public void updateRecord(int db_showTemp, int db_showHealth, int db_showVoltage, int db_showVoltageMilli, int db_showStatus, int db_periodicToasts){
        DataProvider.open();
        DataProvider.updateRecord(1, db_showTemp, db_showHealth, db_showVoltage, db_showVoltageMilli, db_showStatus, db_periodicToasts);
        DataProvider.close();
    }
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        
        retrieveFromDb();
        
        Switch onOff = (Switch)findViewById(R.id.MainActivity_OnOffSwitch);
        onOff.setOnCheckedChangeListener(new OnCheckedChangeListener() {
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if(isChecked == true)
                    startService(new Intent(MainActivity.this,NotificationService.class));
                else 
                    stopService(new Intent(MainActivity.this,NotificationService.class));
            }
        });        
    }
}