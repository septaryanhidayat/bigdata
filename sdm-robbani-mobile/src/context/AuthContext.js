import React, { createContext, useState, useEffect, useContext } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { hrisApi } from '../api/hrisApi';

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [isLoading, setIsLoading] = useState(false);
  const [userToken, setUserToken] = useState(null);
  const [user, setUser] = useState(null);
  const [employee, setEmployee] = useState(null);
  const [unit, setUnit] = useState(null);

  useEffect(() => {
    loadStoredAuth();
  }, []);

  const loadStoredAuth = async () => {
    try {
      const storedToken = await AsyncStorage.getItem('user_token');
      const storedUser = await AsyncStorage.getItem('user_data');
      const storedEmployee = await AsyncStorage.getItem('employee_data');
      const storedUnit = await AsyncStorage.getItem('unit_data');

      if (storedToken && storedUser) {
        setUserToken(storedToken);
        setUser(JSON.parse(storedUser));
        if (storedEmployee) setEmployee(JSON.parse(storedEmployee));
        if (storedUnit) setUnit(JSON.parse(storedUnit));
      }
    } catch (e) {
      console.warn('AsyncStorage check warning', e);
    }
  };

  const login = async (email, password) => {
    try {
      const res = await hrisApi.login(email, password);
      if (res.status === 'success') {
        setUserToken(res.token);
        setUser(res.user);
        setEmployee(res.employee);
        setUnit(res.unit);

        try {
          await AsyncStorage.setItem('user_token', res.token);
          await AsyncStorage.setItem('user_id', String(res.user.id));
          await AsyncStorage.setItem('user_data', JSON.stringify(res.user));
          await AsyncStorage.setItem('employee_data', JSON.stringify(res.employee));
          await AsyncStorage.setItem('unit_data', JSON.stringify(res.unit));
        } catch (storageErr) {
          console.warn('Could not persist to storage', storageErr);
        }

        return { success: true };
      }
      return { success: false, message: res.message || 'Login gagal' };
    } catch (err) {
      const msg = err.response?.data?.message || 'Gagal terhubung ke server SmartEdu.';
      return { success: false, message: msg };
    }
  };

  const logout = async () => {
    try {
      setUserToken(null);
      setUser(null);
      setEmployee(null);
      setUnit(null);
      await AsyncStorage.multiRemove([
        'user_token',
        'user_id',
        'user_data',
        'employee_data',
        'unit_data',
      ]);
    } catch (e) {
      console.error('Error logging out', e);
    }
  };

  return (
    <AuthContext.Provider
      value={{
        isLoading,
        userToken,
        user,
        employee,
        unit,
        login,
        logout,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
