import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import DashboardScreen from '../screens/DashboardScreen';
import AttendanceScreen from '../screens/AttendanceScreen';
import LeaveScreen from '../screens/LeaveScreen';
import PayrollScreen from '../screens/PayrollScreen';
import ProfileScreen from '../screens/ProfileScreen';
import { useTheme } from '../context/ThemeContext';

const Tab = createBottomTabNavigator();

export default function BottomTabNavigator() {
  const { colors } = useTheme();

  return (
    <Tab.Navigator
      screenOptions={{
        headerShown: false,
        tabBarStyle: {
          backgroundColor: colors.surface,
          borderTopColor: colors.border,
          height: 64,
          paddingBottom: 8,
          paddingTop: 8,
        },
        tabBarActiveTintColor: colors.primary,
        tabBarInactiveTintColor: colors.textLight,
        tabBarLabelStyle: {
          fontSize: 10,
          fontWeight: '800',
        },
      }}
    >
      <Tab.Screen
        name="Home"
        component={DashboardScreen}
        options={{
          tabBarLabel: 'Beranda',
          tabBarIcon: ({ color, focused }) => <Text style={{ fontSize: 20 }}>🏠</Text>,
        }}
      />
      <Tab.Screen
        name="Presensi"
        component={AttendanceScreen}
        options={{
          tabBarLabel: 'Presensi',
          tabBarIcon: ({ color, focused }) => <Text style={{ fontSize: 20 }}>📸</Text>,
        }}
      />
      <Tab.Screen
        name="Cuti"
        component={LeaveScreen}
        options={{
          tabBarLabel: 'Cuti & Izin',
          tabBarIcon: ({ color, focused }) => <Text style={{ fontSize: 20 }}>📝</Text>,
        }}
      />
      <Tab.Screen
        name="Payroll"
        component={PayrollScreen}
        options={{
          tabBarLabel: 'Slip Gaji',
          tabBarIcon: ({ color, focused }) => <Text style={{ fontSize: 20 }}>💰</Text>,
        }}
      />
      <Tab.Screen
        name="Profil"
        component={ProfileScreen}
        options={{
          tabBarLabel: 'Profil',
          tabBarIcon: ({ color, focused }) => <Text style={{ fontSize: 20 }}>👤</Text>,
        }}
      />
    </Tab.Navigator>
  );
}
