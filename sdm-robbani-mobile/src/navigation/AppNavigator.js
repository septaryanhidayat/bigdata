import React, { useState } from 'react';
import { View, StyleSheet, ActivityIndicator } from 'react-native';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';
import LoginScreen from '../screens/LoginScreen';
import DashboardScreen from '../screens/DashboardScreen';
import AttendanceScreen from '../screens/AttendanceScreen';
import AttendanceHistoryScreen from '../screens/AttendanceHistoryScreen';
import LeaveScreen from '../screens/LeaveScreen';
import PayrollScreen from '../screens/PayrollScreen';
import KpiScreen from '../screens/KpiScreen';
import CanteenScreen from '../screens/CanteenScreen';
import AnnouncementScreen from '../screens/AnnouncementScreen';
import MutabaahScreen from '../screens/MutabaahScreen';
import BpiScreen from '../screens/BpiScreen';
import ProfileScreen from '../screens/ProfileScreen';
import EditProfileScreen from '../screens/EditProfileScreen';
import FaceEnrollmentScreen from '../screens/FaceEnrollmentScreen';
import QuranScreen from '../screens/QuranScreen';
import AsmaulHusnaScreen from '../screens/AsmaulHusnaScreen';
import AlmatsuratScreen from '../screens/AlmatsuratScreen';
import { TouchableOpacity, Text } from 'react-native';

export default function AppNavigator() {
  const { userToken, isLoading } = useAuth();
  const { colors } = useTheme();

  // Active Screen State
  const [currentScreen, setCurrentScreen] = useState('Home');

  const navigation = {
    navigate: (screenName) => setCurrentScreen(screenName),
    goBack: () => setCurrentScreen('Home'),
  };

  if (isLoading) {
    return (
      <View style={[styles.loadingContainer, { backgroundColor: colors.bg }]}>
        <ActivityIndicator size="large" color={colors.primary} />
      </View>
    );
  }

  // Jika belum login, tampilkan LoginScreen
  if (!userToken) {
    return <LoginScreen />;
  }

  // Render Layar Sesuai State
  const renderScreen = () => {
    switch (currentScreen) {
      case 'Home':
        return <DashboardScreen navigation={navigation} />;
      case 'Presensi':
        return <AttendanceScreen navigation={navigation} />;
      case 'History':
        return <AttendanceHistoryScreen navigation={navigation} />;
      case 'Cuti':
        return <LeaveScreen navigation={navigation} />;
      case 'Payroll':
        return <PayrollScreen navigation={navigation} />;
      case 'Kpi':
        return <KpiScreen navigation={navigation} />;
      case 'Canteen':
        return <CanteenScreen navigation={navigation} />;
      case 'Announcements':
        return <AnnouncementScreen navigation={navigation} />;
      case 'Mutabaah':
        return <MutabaahScreen navigation={navigation} />;
      case 'Bpi':
        return <BpiScreen navigation={navigation} />;
      case 'FaceEnrollment':
        return <FaceEnrollmentScreen navigation={navigation} />;
      case 'EditProfile':
        return <EditProfileScreen navigation={navigation} />;
      case 'Quran':
        return <QuranScreen navigation={navigation} />;
      case 'AsmaulHusna':
        return <AsmaulHusnaScreen navigation={navigation} />;
      case 'Almatsurat':
        return <AlmatsuratScreen navigation={navigation} />;
      case 'Profil':
        return <ProfileScreen navigation={navigation} />;
      default:
        return <DashboardScreen navigation={navigation} />;
    }
  };

  const tabs = [
    { key: 'Home', label: 'Beranda', icon: '🏠' },
    { key: 'Presensi', label: 'Presensi', icon: '📸' },
    { key: 'Mutabaah', label: 'Ibadah', icon: '🕌' },
    { key: 'Cuti', label: 'Cuti', icon: '📝' },
    { key: 'Payroll', label: 'Gaji', icon: '💰' },
    { key: 'Profil', label: 'Profil', icon: '👤' },
  ];

  return (
    <View style={[styles.mainContainer, { backgroundColor: colors.bg }]}>
      {/* Active Screen View */}
      <View style={styles.screenContent}>{renderScreen()}</View>

      {/* Bottom Navigation Bar */}
      <View style={[styles.bottomTabBar, { backgroundColor: colors.surface, borderTopColor: colors.border }]}>
        {tabs.map((tab) => {
          const isActive = currentScreen === tab.key;
          return (
            <TouchableOpacity
              key={tab.key}
              style={[styles.tabItem, isActive && styles.tabItemActive]}
              onPress={() => setCurrentScreen(tab.key)}
              activeOpacity={0.7}
            >
              <Text style={styles.tabIcon}>{tab.icon}</Text>
              <Text
                style={[
                  styles.tabLabel,
                  {
                    color: isActive ? colors.primary : colors.textLight,
                    fontWeight: isActive ? '900' : '600',
                  },
                ]}
              >
                {tab.label}
              </Text>
            </TouchableOpacity>
          );
        })}
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  mainContainer: {
    flex: 1,
    width: '100%',
    height: '100%',
  },
  screenContent: {
    flex: 1,
  },
  loadingContainer: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  bottomTabBar: {
    flexDirection: 'row',
    height: 62,
    borderTopWidth: 1,
    paddingBottom: 6,
    paddingTop: 6,
    shadowColor: '#000',
    shadowOpacity: 0.05,
    shadowRadius: 10,
    elevation: 8,
  },
  tabItem: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  tabItemActive: {
    transform: [{ scale: 1.05 }],
  },
  tabIcon: {
    fontSize: 18,
  },
  tabLabel: {
    fontSize: 10,
    marginTop: 2,
  },
});
