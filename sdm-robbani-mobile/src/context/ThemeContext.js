import React, { createContext, useState, useContext } from 'react';
import { useAuth } from './AuthContext';

const ThemeContext = createContext();

export const ThemeProvider = ({ children }) => {
  const [isDarkMode, setIsDarkMode] = useState(false);
  const { unit } = useAuth();

  const toggleDarkMode = () => setIsDarkMode((prev) => !prev);

  // Palet Warna Dinamis Berdasarkan Unit Sekolah Pegawai
  const unitCode = unit ? unit.code : 'YAYASAN';
  const unitTheme = unit?.theme || {
    primary: '#004532',
    secondary: '#fd761a',
    accent: '#065f46',
    name: 'SIT Robbani',
  };

  const colors = {
    isDark: isDarkMode,
    primary: isDarkMode ? (unitCode === 'YAYASAN' ? '#c6f634' : unitTheme.primary) : unitTheme.primary,
    secondary: unitTheme.secondary,
    accent: unitTheme.accent,
    bg: isDarkMode ? '#061107' : '#f8fafc',
    surface: isDarkMode ? '#0e2010' : '#ffffff',
    surfaceSub: isDarkMode ? '#153018' : '#f1f5f9',
    border: isDarkMode ? '#1a381c' : '#e2e8f0',
    text: isDarkMode ? '#f7fee7' : '#0f172a',
    textSub: isDarkMode ? '#a3e635' : '#64748b',
    textLight: isDarkMode ? '#cbd5e1' : '#475569',
    unitName: unitTheme.name,
    unitCode: unitCode,
  };

  return (
    <ThemeContext.Provider value={{ isDarkMode, toggleDarkMode, colors }}>
      {children}
    </ThemeContext.Provider>
  );
};

export const useTheme = () => useContext(ThemeContext);
