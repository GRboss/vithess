package com.vithess;

import java.util.ArrayList;
import java.util.List;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;


public class MyPagerAdapter extends FragmentPagerAdapter {

	private List<Fragment> fragments;

	public MyPagerAdapter(FragmentManager fm) {
		super(fm);
		this.fragments = new ArrayList<Fragment>();
		fragments.add(new UsersWall());
		fragments.add(new CompanysWall());
		fragments.add(new MunicipalitysWall());
	}

	@Override
	public Fragment getItem(int position) {
		return fragments.get(position);
	}

	@Override
	public int getCount() {
		return fragments.size();
	}
}