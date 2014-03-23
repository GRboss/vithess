package com.vithess;

import com.facebook.Request;
import com.facebook.Response;
import com.facebook.Session;
import com.facebook.SessionState;
import com.facebook.UiLifecycleHelper;
import com.facebook.model.GraphUser;
import com.facebook.widget.LoginButton;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

public class LoginFragment extends Fragment{
	
	private UiLifecycleHelper uiHelper;
	private LoginButton authButton;
	 
	private Session.StatusCallback callback = new Session.StatusCallback() {
		@Override
		public void call(Session session, SessionState state, Exception exception) {
			onSessionStateChange(session, state, exception);
		}
	};
	
	@Override
	public void onCreate (Bundle savedInstanceState){
		super.onCreate(savedInstanceState);
		uiHelper = new UiLifecycleHelper(getActivity(), callback);
		uiHelper.onCreate(savedInstanceState);		
	}
	

	@Override
	public void onResume() {
		super.onResume();
		
		// For scenarios where the main activity is launched and user
		// session is not null, the session state change notification
		// may not be triggered. Trigger it if it's open/closed.
		Session session = Session.getActiveSession();
		if(session != null &&
				(session.isOpened() || session.isClosed()) ) {
			onSessionStateChange(session, session.getState(), null);
		}
		
		uiHelper.onResume();
	}
	
	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		uiHelper.onActivityResult(requestCode, resultCode, data);
	}
	
	@Override
	public void onPause() {
		super.onPause();
		uiHelper.onPause();
	}
	
	@Override
	public void onDestroy() {
		super.onDestroy();
		uiHelper.onDestroy();
	}
	
	@Override
	public void onSaveInstanceState(Bundle outState) {
		super.onSaveInstanceState(outState);
		uiHelper.onSaveInstanceState(outState);
	}
	
	@Override
	public View onCreateView(LayoutInflater inflater,
			ViewGroup container,
			Bundle savedInstance){
		View view = inflater.inflate(R.layout.activity_main, container, false);
		
		authButton = (LoginButton) view.findViewById(R.id.authButton);
		authButton.setFragment(this);
		authButton.setVisibility(View.VISIBLE);
		return view;
	}

	
	/**
	 * Session changed (closed or opened)
	 */
	private void onSessionStateChange (Session session, SessionState state, Exception exception){
		
		authButton.setVisibility(View.INVISIBLE);
		
		if (state.isOpened()) {
			Toast.makeText(getActivity(), "Έχετε συνδεθεί με επιτυχία", Toast.LENGTH_SHORT).show();
			
			// Request user data and show the results
			Request.newMeRequest(session, new Request.GraphUserCallback(){

				@Override
				public void onCompleted(GraphUser user, Response response) {
					if (user != null) {
		               Intent intent = new Intent(getActivity(), ListMessages.class);
		               intent.putExtra("UserId",user.getId());
		               intent.putExtra("Username", user.getUsername());
		               startActivity(intent);
					} else {           
			        	 authButton.setVisibility(View.VISIBLE);
					}
					
				}
			}).executeAsync();			
			
		} else if (state.isClosed()) {
			authButton.setVisibility(View.VISIBLE);
			Toast.makeText(getActivity(), "Αποσυνδεθήκατε!", Toast.LENGTH_SHORT).show();
		}
	}
}