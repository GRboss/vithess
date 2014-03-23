package com.vithess;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.message.BasicNameValuePair;

import com.facebook.FacebookException;
import com.facebook.Session;
import com.facebook.widget.WebDialog;
import com.facebook.widget.WebDialog.OnCompleteListener;

import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.Settings;
import android.app.ActionBar;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.FragmentTransaction;
import android.app.ActionBar.Tab;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentActivity;
import android.support.v4.view.ViewPager;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.PopupMenu;
import android.widget.Toast;
import android.widget.PopupMenu.OnMenuItemClickListener;
import android.widget.TextView;

public class ListMessages extends FragmentActivity implements LocationListener {
	
	/**
	 * FACEBOOK DATA
	 */
	private int userId;
	private String username;
	
	/**
	 * GPS
	 */
	 private Context mContext;
	 
	 // flag for GPS status
	 boolean isGPSEnabled = false;
	 
	 // flag for network status
	 boolean isNetworkEnabled = false;
	 
	 // flag for GPS status
	 boolean canGetLocation = false;
	 
	 Location location; // location
	 
	 // The minimum distance to change Updates in meters
	 private static final long MIN_DISTANCE_CHANGE_FOR_UPDATES = 10; // 10 meters
	 
	 // The minimum time between updates in milliseconds
	 private static final long MIN_TIME_BW_UPDATES = 1000 * 60 * 1; // 1 minute
	 
	 // Declaring a Location Manager
	 protected LocationManager locationManager;
	 

	/**
	 * OTHER
	 */
	MyPagerAdapter pageAdapter;
	ViewPager pager;	
	
	String PROVIDER = LocationManager.GPS_PROVIDER;
	
	HttpClient client;
	HttpPost post;
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		
		//FACEBOOK DATA
		this.getFacebookData();		
		
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_list_messages);	
		
		//GPS
		this.initializeGPS();
		  
		//SWIPE TABS
		this.initializePageadapter();

		//ACTION BAR
		this.initializeActionBar();		
		
	}
	
	@Override
	protected void onPause() {
		super.onPause();
		locationManager.removeUpdates(this);
	}
	  
	 @Override
	 protected void onResume() {	  
		 super.onResume();
		 locationManager.requestLocationUpdates(PROVIDER, 0, 0, this); //LocationListener
	 }
	 
	 private void getFacebookData() {
		 userId   = Integer.parseInt(getIntent().getExtras().getString("UserId"));
		 username = getIntent().getExtras().getString("Username");
	 }
	 
	 private void initializeGPS() {
		 this.mContext = this;
	     getLocation();
	     if(canGetLocation()){	            
	        showMyLocation();
	     }else{
	        showSettingsAlert();
	     }
	 }
	 
	 private void initializePageadapter() {
		 pageAdapter = new MyPagerAdapter(getSupportFragmentManager());
		 
		 pager       = (ViewPager) findViewById(R.id.myViewPager);
		 pager.setAdapter(pageAdapter);
		 pager.setOnPageChangeListener( new ViewPager.SimpleOnPageChangeListener() {
			 @Override
		     public void onPageSelected(int position) {
		         getActionBar().setSelectedNavigationItem(position);
		     }
		 });			
	 }
	 
	 private void initializeActionBar() {
		final ActionBar actionBar = getActionBar();
		actionBar.setNavigationMode(ActionBar.NAVIGATION_MODE_TABS);
		actionBar.setDisplayShowHomeEnabled(true); 
			
		ActionBar.TabListener tabListener = new ActionBar.TabListener() {

			@Override
			public void onTabReselected(Tab tab, FragmentTransaction ft) {
					
			}

			@Override
			public void onTabSelected(Tab tab, FragmentTransaction ft) {
				getMessages();
				pager.setCurrentItem(tab.getPosition());					
			}

			@Override
			public void onTabUnselected(Tab tab, FragmentTransaction ft) {
					
			}
		};
		
		View tabView1 = getLayoutInflater().inflate(R.layout.actionbar_tab, null);
		TextView tabText1 = (TextView) tabView1.findViewById(R.id.tabText);
		tabText1.setText("ΜΗΝΥΜΑΤΑ");
		ImageView tabImage1 = (ImageView) tabView1.findViewById(R.id.tabIcon);
		tabImage1.setImageDrawable(getResources().getDrawable(R.drawable.user));
		Tab users = actionBar.newTab();
		users.setTabListener(tabListener);
		users.setCustomView(tabView1);
		actionBar.addTab(users);
		
		View tabView2 = getLayoutInflater().inflate(R.layout.actionbar_tab, null);
		TextView tabText2 = (TextView) tabView2.findViewById(R.id.tabText);
		tabText2.setText("ΠΡΟΣΦΟΡΕΣ");
		ImageView tabImage2 = (ImageView) tabView2.findViewById(R.id.tabIcon);
		tabImage2.setImageDrawable(getResources().getDrawable(R.drawable.store));
		Tab offers = actionBar.newTab();
		offers.setTabListener(tabListener);
		offers.setCustomView(tabView2);
		actionBar.addTab(offers);
		
		
		View tabView3 = getLayoutInflater().inflate(R.layout.actionbar_tab, null);
		TextView tabText3 = (TextView) tabView3.findViewById(R.id.tabText);
		tabText3.setText("ΔΗΜΟΣ");
		ImageView tabImage3 = (ImageView) tabView3.findViewById(R.id.tabIcon);
		tabImage3.setImageDrawable(getResources().getDrawable(R.drawable.mun));
		Tab mun = actionBar.newTab();
		mun.setTabListener(tabListener);
		mun.setCustomView(tabView3);
		actionBar.addTab(mun);
	 }
	 
	 
	 
	 /////////////////////////////////////////////////////////////////
	 
	/**
	 * BUTTON LISTENERS
	*/
     public void likeMessage(View view) {
    	 ListView listview1 = (ListView) view.getParent().getParent().getParent();

    	 final int position = listview1.getPositionForView((View) view.getParent());
    	 Message msg = (Message) listview1.getItemAtPosition(position);
    	 
    	 int msg_id = msg.getId();
    	 rateMessage("like",msg_id);
    	 Toast.makeText( this, "Η ψήφος σας αποθηκεύτηκε!", Toast.LENGTH_SHORT).show();
     }
      
     public void dislikeMessage(View view) {
    	 ListView listview1 = (ListView) view.getParent().getParent().getParent();

    	 final int position = listview1.getPositionForView((View) view.getParent());
    	 Message msg = (Message) listview1.getItemAtPosition(position);
    	 
    	 int msg_id = msg.getId();
    	 rateMessage("dislike",msg_id);
    	 Toast.makeText( this, "Η ψήφος σας αποθηκεύτηκε!", Toast.LENGTH_SHORT).show();
     }

     public void reportMessage (View view) {
    	 ListView listview1 = (ListView) view.getParent().getParent().getParent();

    	 final int position = listview1.getPositionForView((View) view.getParent());
    	 Message msg = (Message) listview1.getItemAtPosition(position);
    	 
    	 int msg_id = msg.getId();
    	 rateMessage("report",msg_id);
    	 Toast.makeText( this, "Έχουμε ενημερωθεί για την αναφορά σας!", Toast.LENGTH_SHORT).show();
     }
     
     public void shareMessage(View view) {
    	 ListView listview1 = (ListView) view.getParent().getParent();
    	 final int position = listview1.getPositionForView((View) view.getParent());
    	 Message msg = (Message) listview1.getItemAtPosition(position);
    	 
    	 String msg_title = msg.getTitle();
    	 String msg_txt   = msg.getTeaser();
    	 
    	 Bundle params = new Bundle();
 	    params.putString("name", msg_title);
 	    params.putString("caption", "from Vithess");
 	    params.putString("description", msg_txt);
 	    params.putString("link", "http://oswinds.csd.auth.gr/vithess/");
 	    WebDialog feedDialog = (
 	        new WebDialog.FeedDialogBuilder(this,
 	            Session.getActiveSession(),
 	            params))
 	        .setOnCompleteListener(new OnCompleteListener() {

 	            @Override
 	            public void onComplete(Bundle values,
 	                FacebookException error) {
 	                if (error == null) {
 	                    final String postId = values.getString("post_id");
 	                    if (postId != null) {
 	                    	Toast.makeText( mContext, "Το μήνυμα δημοσιεύτηκε.", Toast.LENGTH_SHORT).show(); 	                        
 	                    }
 	                } else {
 	                	Toast.makeText( mContext, "Προέκυψε κάποιο σφάλμα.", Toast.LENGTH_SHORT).show(); 
 	                }
 	            }				

 	        })
 	        .build();
 	    feedDialog.show();
    	
     }
	
     
     
     /////////////////////////////////////////////////////////////////
     
     /**
      * HttpRequests
	 */     
     private void createMessage(String title, String text) {
    	 ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);		 
		 NetworkInfo ni         = cm.getActiveNetworkInfo();
		 
		 if(location == null) {
			 Toast.makeText( mContext, "Δεν βρέθηκε η τοποθεσία σας!", Toast.LENGTH_SHORT).show();  
		 } else {
			 if(ni != null && ni.isConnected()) {
				 String stringUrl = "http://oswinds.csd.auth.gr/vithess/index.php/api/create_new_message";
				 CreateMessageTask rmt = new CreateMessageTask(title, text);
				 rmt.execute(stringUrl);
			 }
		 }
		 
    	 
     }
     
     private void rateMessage(String action, int msg_id) {

    	 ConnectivityManager cm = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);		 
		 NetworkInfo ni         = cm.getActiveNetworkInfo();
		 
		 if(ni != null && ni.isConnected()) {
			 String stringUrl = "http://oswinds.csd.auth.gr/vithess/index.php/api/rate_the_message/"+userId+"/"+msg_id+"/"+action;
			 RateMessageTask rmt = new RateMessageTask();
			 rmt.execute(stringUrl);
		 }
     }
     
	 private void getMessages(){
		 
		 ConnectivityManager cm = (ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);		 
		 NetworkInfo ni = cm.getActiveNetworkInfo();
		 
		 if(location == null) {
			 Toast.makeText( mContext, "Δεν υπάρχει αποθηκευμένη η τοποθεσία σας!", Toast.LENGTH_SHORT).show();  
		 } else {
			 if(ni != null && ni.isConnected()) {
				 //int activeTab_position=1;
				 int activeTab_position = this.getActionBar().getSelectedTab().getPosition()+1;
				 String stringUrl = "http://oswinds.csd.auth.gr/vithess/index.php/api/get_messages/"
						 		+ location.getLongitude() + "/" + location.getLatitude() + "/"
						 		+ userId + "/" + activeTab_position +"/";
				 Log.d("URLΜ",stringUrl);
				 DownloadMessagesTask dmt = new DownloadMessagesTask(activeTab_position);
				 dmt.execute(stringUrl);
				 
			 }
		 }
	 }
	
	 /**
	  * GET MESSAGES
	 */
	 private class DownloadMessagesTask extends AsyncTask<String, Void, String> {
		private int category;
			
		protected DownloadMessagesTask(int category) {
			super();
			this.category=category-1;
		}
			
		@Override
		protected String doInBackground(String... urls) {
			try {
				return downloadUrl(urls[0]);
			} catch (IOException e) {
				return "Unable to retrieve webpage URL maybe invalid";
			}
		}
			
		@Override
		protected void onPostExecute(String result) {
			Fragment wall = pageAdapter.getItem(category);
			if(wall instanceof UsersWall) {
				((UsersWall)wall).loadMessages(result);
			} else if(wall instanceof CompanysWall){
				((CompanysWall)wall).loadMessages(result);
			} else if(wall instanceof MunicipalitysWall){
				((MunicipalitysWall)wall).loadMessages(result);
			}
		}

		private String downloadUrl(String myurl) throws IOException {
			InputStream is = null;
			int len = 500;
				
			try{
				URL url = new URL(myurl);
				HttpURLConnection conn = (HttpURLConnection) url.openConnection();
				conn.setReadTimeout(10000);
				conn.setConnectTimeout(15000);
				conn.setRequestMethod("GET");
				conn.setDoInput(true);
				conn.connect();

				is=conn.getInputStream();
				String contentAsString = readIt(is,len);
				return contentAsString;
			} finally {
				if(is!=null)
					is.close();
			}
		}
			
		public String readIt(InputStream stream, int len) throws IOException, UnsupportedEncodingException {
			BufferedReader bufferedReader = new BufferedReader( new InputStreamReader(stream));
		    String line = "";
		    String result = "";
		    while((line = bufferedReader.readLine()) != null)
		    	result += line;
		 
		    return result;
		}
	}

	 
	/**
	  * CREATE MESSAGE
	*/	
	private class CreateMessageTask extends AsyncTask<String, Void, String> {
		
		private String message_title;
		private String message_text;
			
		protected CreateMessageTask(String message_title, String message_text) {
			super();
			this.message_title = message_title;
			this.message_text  = message_text;
		}
			
		@Override
		protected String doInBackground(String... urls) {
			try {
				return downloadUrl(urls[0]);
			} catch (IOException e) {
				return "Unable to retrieve webpage URL maybe invalid";
			}
		}
			
		@Override
		protected void onPostExecute(String result) {
			getMessages();		
			Toast.makeText( mContext, "Το μήνυμα σας αποθηκεύτηκε.", Toast.LENGTH_SHORT).show();
		}

		private String downloadUrl(String myurl) throws IOException {
			Log.d("Test","Test");
			InputStream is = null;
			int len = 500;
				
			try{
				URL url = new URL(myurl);
				HttpURLConnection conn = (HttpURLConnection) url.openConnection();
				conn.setReadTimeout(10000);
				conn.setConnectTimeout(15000);
				conn.setRequestMethod("POST");
				conn.setDoInput(true);					
				conn.setDoOutput(true);
				Log.d("user_latitude",Double.toString(location.getLatitude()));
				Log.d("user_longitude",Double.toString(location.getLongitude()));
				Log.d("user_id", Integer.toString(userId));
				Log.d("user_name", username);
				Log.d("message_title", message_title);
				Log.d("message_text", message_text);
				List<NameValuePair> params = new ArrayList<NameValuePair>();
				
				params.add(new BasicNameValuePair("user_latitude", Double.toString(location.getLatitude())));
				params.add(new BasicNameValuePair("user_longitude", Double.toString(location.getLongitude())));
				params.add(new BasicNameValuePair("user_id", Integer.toString(userId)));
				params.add(new BasicNameValuePair("user_name", username));
				params.add(new BasicNameValuePair("message_title", message_title));
				params.add(new BasicNameValuePair("message_text", message_text));
					
				OutputStream os = conn.getOutputStream();
				BufferedWriter writer = new BufferedWriter(
					        new OutputStreamWriter(os, "UTF-8"));
				writer.write(getQuery(params));
				writer.flush();
				writer.close();
				os.close();
				conn.connect();
					
				is=conn.getInputStream();
				String contentAsString = readIt(is,len);
				Log.d("result",contentAsString);
				return contentAsString;
			} finally {
				if(is!=null)
					is.close();
			}
		}
		
		private String getQuery(List<NameValuePair> params) throws UnsupportedEncodingException {
		    StringBuilder result = new StringBuilder();
		    boolean first = true;

		    for (NameValuePair pair : params) {
		        if (first)
		            first = false;
		        else
		            result.append("&");

		        result.append(URLEncoder.encode(pair.getName(), "UTF-8"));
		        result.append("=");
		        result.append(URLEncoder.encode(pair.getValue(), "UTF-8"));
		    }
		    return result.toString();
		}

		public String readIt(InputStream stream, int len) throws IOException, UnsupportedEncodingException {
			BufferedReader bufferedReader = new BufferedReader( new InputStreamReader(stream));
		    String line = "";
		    String result = "";
		    while((line = bufferedReader.readLine()) != null)
		    	result += line;
		 
		    return result;
		}
	}
		 
	 
	/**
	 * RATE MESSAGES
	 */	
	private class RateMessageTask extends AsyncTask<String, Void, String> {
		
		@Override
		protected String doInBackground(String... urls) {
			try {
				return downloadUrl(urls[0]);
			} catch (IOException e) {
				return "Unable to retrieve webpage URL maybe invalid";
			}
		}
		
		@Override
		protected void onPostExecute(String result) {
			
		}

		private String downloadUrl(String myurl) throws IOException {
			InputStream is = null;
			int len = 500;
			
			try{
				URL url = new URL(myurl);
				HttpURLConnection conn = (HttpURLConnection) url.openConnection();
				conn.setReadTimeout(10000);
				conn.setConnectTimeout(15000);
				conn.setRequestMethod("GET");
				conn.setDoInput(true);
				conn.connect();
				
				is=conn.getInputStream();
				String contentAsString = readIt(is,len);
				return contentAsString;
			} finally {
				if(is!=null)
					is.close();
			}
		}
		
		public String readIt(InputStream stream, int len) throws IOException, UnsupportedEncodingException {
			BufferedReader bufferedReader = new BufferedReader( new InputStreamReader(stream));
	        String line = "";
	        String result = "";
	        while((line = bufferedReader.readLine()) != null)
	            result += line;
	 
	        return result;
		}
	}
	  
	
	
	/////////////////////////////////////////////////////////////////
		  
	/**
	* MENU LISTENER
	*/
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		MenuInflater mif = getMenuInflater();
		mif.inflate(R.menu.list_messages, menu);
		
		return super.onCreateOptionsMenu(menu);
	}
		 
	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle presses on the action bar items
		switch (item.getItemId()) {
			case R.id.add_icon:
				addMessage();
				return true;
			case R.id.refresh_icon:
				getMessages();
				return true;
			case R.id.submenu:
		    	popSubmenu(item);
		    	return true;
		    default:
		    	return super.onOptionsItemSelected(item);
		}
	}
	
	/**
	 * Add Message
	 */
	private void addMessage() {
		
		// custom dialog
		final Dialog dialog = new Dialog(this);
		dialog.setContentView(R.layout.add_dialog);
		dialog.setTitle("Νέο Μήνυμα");
		
		Button okButton = (Button)dialog.findViewById(R.id.doAddMessage);
		//If button is clicked, close the custom dialog
		okButton.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				EditText msg_titleEdit = (EditText) dialog.findViewById(R.id.new_title_message);
				String msg_title       = msg_titleEdit.getText().toString();
				EditText msg_textEdit  = (EditText) dialog.findViewById(R.id.new_text_message);
				String msg_text        = msg_textEdit.getText().toString();
				
				if(msg_title != "" && msg_text!=""){
					createMessage(msg_title, msg_text);
					 dialog.dismiss();
				}
			}
			
		});
		
		Button cancelButton = (Button)dialog.findViewById(R.id.cancelAddMessage);
		cancelButton.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {
				dialog.dismiss();				
			}
			
		});
		dialog.show();
	}
	
	/**
	 * Sub-menu
	 */
	private void popSubmenu(MenuItem item) {
		View menuItemView = findViewById(R.id.submenu);
		PopupMenu popup   = new PopupMenu(this,menuItemView);
		
		popup.setOnMenuItemClickListener(new OnMenuItemClickListener() {

			@Override
			public boolean onMenuItemClick(MenuItem item) {
				switch (item.getItemId()) {
					case R.id.about:
						about();
						return true;
				    case R.id.logout:
				    	logout();
				        return true;
				    default:
				        return false;
				}
			}
		});
			 
		MenuInflater inflater = popup.getMenuInflater();
		inflater.inflate(R.menu.submenu, popup.getMenu());
		popup.show();
	}
		 
	/**
	 * Function logout
	*/
	public void logout() {
		Session session = Session.getActiveSession();		
		if (!session.isClosed()) {
			
			session.closeAndClearTokenInformation();
			Intent intent = new Intent(this, MainActivity.class);
	        startActivity(intent);
	        
		}
	}
		 
	/**
	 * Function about
	*/
	@SuppressWarnings("deprecation")
	public void about() {
		AlertDialog alertDialog = new AlertDialog.Builder(this).create();
		alertDialog.setTitle(R.string.about);
		alertDialog.setMessage("Το ViThess είναι μία εφαρμογή η οποία αναπτύχθηκε από την Λάτσιου Γεωργία και τον Καπίρη Στέφανο, σε συνεργασία με τo AΠΘ, και στόχος της είναι να προωθήσει την Θεσσαλονίκη ως έξυπνη πόλη.");
		alertDialog.setButton("OK", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int which) { }
		});
		alertDialog.show();
	}
	
	/**
	 * Function settings
	*/
	public void settings() {
			 
	}
	
	
	
	/////////////////////////////////////////////////////////////////
	
	/**
	 * GPS FUNCTIONS
	 */
	private void showMyLocation(){
//		if(location == null){
//			Log.d("List Messages","No Location!");
//		} else {
//			Log.d("List Messages","Latitude: " + location.getLatitude());
//			Log.d("List Messages","Longitude: " + location.getLongitude());
//		}		    
	}
	
	public Location getLocation() {
        try {
            locationManager = (LocationManager) mContext
                    .getSystemService(LOCATION_SERVICE);
 
            // getting GPS status
            isGPSEnabled = locationManager
                    .isProviderEnabled(LocationManager.GPS_PROVIDER);
 
            // getting network status
            isNetworkEnabled = locationManager
                    .isProviderEnabled(LocationManager.NETWORK_PROVIDER);
 
            if (!isGPSEnabled && !isNetworkEnabled) {
                // no network provider is enabled
            } else {
                this.canGetLocation = true;
                // First get location from Network Provider
                if (isNetworkEnabled) {
                    locationManager.requestLocationUpdates(
                            LocationManager.NETWORK_PROVIDER,
                            MIN_TIME_BW_UPDATES,
                            MIN_DISTANCE_CHANGE_FOR_UPDATES, this);
                    if (locationManager != null) {
                        location = locationManager
                                .getLastKnownLocation(LocationManager.NETWORK_PROVIDER);
                    }
                }
                // if GPS Enabled get lat/long using GPS Services
                if (isGPSEnabled) {
                    if (location == null) {
                        locationManager.requestLocationUpdates(
                                LocationManager.GPS_PROVIDER,
                                MIN_TIME_BW_UPDATES,
                                MIN_DISTANCE_CHANGE_FOR_UPDATES, this);
                        if (locationManager != null) {
                            location = locationManager
                                    .getLastKnownLocation(LocationManager.GPS_PROVIDER);
                        }
                    }
                }
            }
 
        } catch (Exception e) {
            e.printStackTrace();
        }
 
        return location;
    }
	

    /**
     * Function to check GPS/wifi enabled
     * @return boolean
     * */
    public boolean canGetLocation() {
        return this.canGetLocation;
    }
    
    
    /**
     * Function to show settings alert dialog
     * On pressing Settings button will lauch Settings Options
     * */
    public void showSettingsAlert(){
        AlertDialog.Builder alertDialog = new AlertDialog.Builder(mContext);
      
        // Setting Dialog Title
        alertDialog.setTitle("GPS is settings");
  
        // Setting Dialog Message
        alertDialog.setMessage("GPS is not enabled. Do you want to go to settings menu?");
  
        // On pressing Settings button
        alertDialog.setPositiveButton("Settings", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog,int which) {
                Intent intent = new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS);
                mContext.startActivity(intent);
            }
        });
  
        // on pressing cancel button
        alertDialog.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int which) {
            dialog.cancel();
            }
        });
  
        // Showing Alert Message
        alertDialog.show();
    }
    
    
    @Override
    public void onLocationChanged(Location location) {
    	getLocation();
    	getMessages();
    }
 
    @Override
    public void onProviderDisabled(String provider) {
    }
 
    @Override
    public void onProviderEnabled(String provider) {
    }
 
    @Override
    public void onStatusChanged(String provider, int status, Bundle extras) {
    }
	
}



