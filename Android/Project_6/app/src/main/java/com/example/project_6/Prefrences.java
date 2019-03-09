package com.example.project_6;

import android.content.Context;
import android.content.SharedPreferences;

public class Prefrences {
    private Context context;
    private SharedPreferences sharedPreferences;

    Prefrences(Context context)
    {
        this.context=context;
        getSharedPreferences();
    }


    private void getSharedPreferences() {
        sharedPreferences=context.getSharedPreferences("Login",Context.MODE_PRIVATE);
    }
    public void writeYesPreference()
    {
        SharedPreferences.Editor editor=sharedPreferences.edit();
        editor.putString("isLogin","Yes");
//        editor.putString("email",email);
        editor.commit();
    }
    public void writeNoPreference()
    {
        SharedPreferences.Editor editor=sharedPreferences.edit();
        editor.putString("isLogin","No");
        editor.commit();
    }
    public String getEmail(){
        return sharedPreferences.getString("email","");
    }
    public void setEmail(String email){
        SharedPreferences.Editor editor=sharedPreferences.edit();
        editor.putString("email",email);
        editor.commit();
    }
    boolean checkPreference()
    {
        boolean status=false;
        status = (sharedPreferences.getString("isLogin", "No")).equals("Yes");
        return status;
    }
}
