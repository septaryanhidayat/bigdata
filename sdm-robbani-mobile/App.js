import React from 'react';
import { View, StyleSheet, Platform } from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { SafeAreaProvider } from 'react-native-safe-area-context';
import { registerRootComponent } from 'expo';
import { AuthProvider } from './src/context/AuthContext';
import { ThemeProvider, useTheme } from './src/context/ThemeContext';
import AppNavigator from './src/navigation/AppNavigator';

function MainApp() {
  const { isDarkMode, colors } = useTheme();
  return (
    <SafeAreaProvider style={[styles.container, { backgroundColor: isDarkMode ? '#061107' : '#004532' }]}>
      <StatusBar style={isDarkMode ? 'light' : 'dark'} />
      <View style={[styles.appWrapper, { backgroundColor: colors.bg }]}>
        <AppNavigator />
      </View>
    </SafeAreaProvider>
  );
}

export default function App() {
  return (
    <AuthProvider>
      <ThemeProvider>
        <MainApp />
      </ThemeProvider>
    </AuthProvider>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    width: '100%',
    ...(Platform.OS === 'web' ? { height: '100vh' } : {}),
  },
  appWrapper: {
    flex: 1,
    width: '100%',
    maxWidth: 480,
    alignSelf: 'center',
    ...(Platform.OS === 'web' ? { height: '100vh' } : {}),
  },
});

// Daftarkan komponen utama ke AppRegistry Expo
registerRootComponent(App);
