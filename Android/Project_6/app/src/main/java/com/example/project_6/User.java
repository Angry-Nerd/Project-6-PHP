package com.example.project_6;

import android.content.Intent;
import android.support.annotation.NonNull;
import android.support.design.widget.NavigationView;
import android.support.design.widget.Snackbar;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.Gravity;
import android.view.MenuItem;
import android.view.View;

public class User extends AppCompatActivity {

    private DrawerLayout mDrawerLayout;
    String email;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_user);
        Intent intent = getIntent();
        email = intent.getExtras().getString("email");
        mDrawerLayout = findViewById(R.id.drawer_layout);
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        NavigationView navigationView = findViewById(R.id.nav_view);
        ActionBar actionbar = getSupportActionBar();
        actionbar.setDisplayHomeAsUpEnabled(true);
        actionbar.setHomeAsUpIndicator(R.drawable.ic_menu);
        navigationView.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                int id=item.getItemId();
                switch (id)
                {
                    case R.id.profile:
                    {
                        Intent intent = new Intent(getApplicationContext(),Profile.class);
                        intent.putExtra("email",email);
                        startActivity(intent);
                        break;
                    }
                    case R.id.logout: {
                        new Prefrences(User.this).writeNoPreference();
                        startActivity(new Intent(getApplicationContext(),MainActivity.class));
                        finish();
                        break;
                    }
                    case R.id.about_us:
                        startActivity(new Intent(getApplicationContext(),About_Us.class));
                        break;
                    case R.id.info_benefits:
                        startActivity(new Intent(getApplicationContext(),info_benefits.class));
                        break;
                }
                mDrawerLayout.closeDrawer(Gravity.START,true);
                return true;
            }

        });
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                mDrawerLayout.openDrawer(GravityCompat.START);
                return true;
        }
        return super.onOptionsItemSelected(item);
    }

    public void showLists(View view) {
        Intent intent1 = new Intent(User.this,List.class);
        intent1.putExtra("email",email);
        startActivity(intent1);
    }

    public void ambulance(View view) {
        Intent intent1 = new Intent(User.this,Ambulance.class);
        intent1.putExtra("email",email);
        startActivity(intent1);
    }

    public void camp(View view) {
        Intent intent1 = new Intent(User.this,DataForm.class);
        intent1.putExtra("email",email);
        startActivity(intent1);
    }
}
