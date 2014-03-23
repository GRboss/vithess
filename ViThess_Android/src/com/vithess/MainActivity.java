package com.vithess;

import android.os.Bundle;
import android.support.v4.app.FragmentActivity;

public class MainActivity extends FragmentActivity {

	private LoginFragment mainFragment;
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		if(savedInstanceState == null) {
			//Add the fragment on initial activity setup
			mainFragment = new LoginFragment();
			getSupportFragmentManager()
			.beginTransaction()
			.add(android.R.id.content, mainFragment)
			.commit();
		} else {
			
			mainFragment = (LoginFragment) getSupportFragmentManager()
					.findFragmentById(android.R.id.content);
		}
		setContentView(R.layout.activity_main);	
		
	}
}

