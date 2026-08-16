import React from 'react';
import { View, ActivityIndicator, StyleSheet } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { useAuth } from '../context/AuthContext';
import LoginScreen from '../screens/LoginScreen';
import BottomTabNavigator from './BottomTabNavigator';
import AttendanceHistoryScreen from '../screens/AttendanceHistoryScreen';
import KpiScreen from '../screens/KpiScreen';
import CanteenScreen from '../screens/CanteenScreen';
import AnnouncementScreen from '../screens/AnnouncementScreen';
import MutabaahScreen from '../screens/MutabaahScreen';
import BpiScreen from '../screens/BpiScreen';
import { useTheme } from '../context/ThemeContext';

const Stack = createNativeStackNavigator();

export default function AppNavigator() {
  const { userToken, isLoading } = useAuth();
  const { colors } = useTheme();

  if (isLoading) {
    return (
      <View style={[styles.loadingContainer, { backgroundColor: colors.bg }]}>
        <ActivityIndicator size="large" color={colors.primary} />
      </View>
    );
  }

  return (
    <NavigationContainer>
      <Stack.Navigator screenOptions={{ headerShown: false }}>
        {userToken === null ? (
          <Stack.Screen name="Login" component={LoginScreen} />
        ) : (
          <>
            <Stack.Screen name="Main" component={BottomTabNavigator} />
            <Stack.Screen name="History" component={AttendanceHistoryScreen} />
            <Stack.Screen name="Kpi" component={KpiScreen} />
            <Stack.Screen name="Canteen" component={CanteenScreen} />
            <Stack.Screen name="Announcements" component={AnnouncementScreen} />
            <Stack.Screen name="Mutabaah" component={MutabaahScreen} />
            <Stack.Screen name="Bpi" component={BpiScreen} />
          </>
        )}
      </Stack.Navigator>
    </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  loadingContainer: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
});
