import React from 'react';
import { View, StyleSheet, Platform } from 'react-native';
import { StatusBar } from 'expo-status-bar';
import { SafeAreaProvider } from 'react-native-safe-area-context';
import { enableScreens } from 'react-native-screens';
import { AuthProvider } from './src/context/AuthContext';
import { ThemeProvider, useTheme } from './src/context/ThemeContext';
import AppNavigator from './src/navigation/AppNavigator';

// Di web, matikan native screens untuk mencegah blank canvas pada stack navigator
if (Platform.OS === 'web') {
  enableScreens(false);
}

function MainApp() {
  const { isDarkMode, colors } = useTheme();
  return (
    <SafeAreaProvider style={[styles.root, { backgroundColor: isDarkMode ? '#061107' : '#004532' }]}>
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
  root: {
    flex: 1,
    width: '100%',
    minHeight: Platform.OS === 'web' ? '100vh' : '100%',
    alignItems: 'center',
    justifyContent: 'center',
  },
  appWrapper: {
    flex: 1,
    width: '100%',
    maxWidth: 500, // Menjaga rasio tampilan smartphone yang pas dan rapi saat dibuka di browser laptop/PC
    minHeight: Platform.OS === 'web' ? '100vh' : '100%',
    shadowColor: '#000',
    shadowOpacity: 0.15,
    shadowRadius: 20,
    elevation: 5,
  },
});
