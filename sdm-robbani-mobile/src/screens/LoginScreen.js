import React, { useState } from 'react';
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  ActivityIndicator,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
} from 'react-native';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';

export default function LoginScreen() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');

  const { login } = useAuth();
  const { colors } = useTheme();

  const handleLogin = async () => {
    if (!email.trim() || !password.trim()) {
      setErrorMessage('Harap isi Email/NIP dan Kata Sandi.');
      return;
    }

    setIsLoading(true);
    setErrorMessage('');

    const res = await login(email.trim(), password);
    setIsLoading(false);

    if (!res.success) {
      setErrorMessage(res.message);
    }
  };

  const handleQuickFill = (userEmail, userPass) => {
    setEmail(userEmail);
    setPassword(userPass);
  };

  return (
    <KeyboardAvoidingView
      style={[styles.container, { backgroundColor: colors.bg }]}
      behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
    >
      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Logo & Header */}
        <View style={styles.header}>
          <View style={[styles.logoCircle, { backgroundColor: colors.primary }]}>
            <Text style={styles.logoIcon}>🕌</Text>
          </View>
          <Text style={[styles.brandTitle, { color: colors.text }]}>SDM SIT ROBBANI</Text>
          <Text style={[styles.brandSubtitle, { color: colors.textLight }]}>
            Portal Kepegawaian, Presensi Wajah &amp; HRIS Terpadu
          </Text>
          <View style={[styles.unitPillsRow]}>
            <Text style={[styles.unitPill, { backgroundColor: '#dcfce7', color: '#166534' }]}>TKIT</Text>
            <Text style={[styles.unitPill, { backgroundColor: '#ffedd5', color: '#9a3412' }]}>SDIT</Text>
            <Text style={[styles.unitPill, { backgroundColor: '#dbeafe', color: '#1e40af' }]}>SMPIT</Text>
            <Text style={[styles.unitPill, { backgroundColor: '#f3e8ff', color: '#6b21a8' }]}>SMAIT</Text>
            <Text style={[styles.unitPill, { backgroundColor: '#e2e8f0', color: '#0f172a' }]}>YAYASAN</Text>
          </View>
        </View>

        {/* Card Form */}
        <View style={[styles.formCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Text style={[styles.formTitle, { color: colors.text }]}>Masuk ke Akun Anda</Text>
          <Text style={[styles.formSubtitle, { color: colors.textLight }]}>
            Gunakan email terdaftar atau NIP pegawai Anda
          </Text>

          {errorMessage ? (
            <View style={styles.errorBox}>
              <Text style={styles.errorText}>⚠️ {errorMessage}</Text>
            </View>
          ) : null}

          <View style={styles.inputGroup}>
            <Text style={[styles.inputLabel, { color: colors.text }]}>Email atau NIP</Text>
            <TextInput
              style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
              placeholder="contoh: guru@sitrobbani.sch.id / NIP"
              placeholderTextColor="#94a3b8"
              value={email}
              onChangeText={setEmail}
              autoCapitalize="none"
              keyboardType="email-address"
            />
          </View>

          <View style={styles.inputGroup}>
            <Text style={[styles.inputLabel, { color: colors.text }]}>Kata Sandi</Text>
            <TextInput
              style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
              placeholder="Masukkan kata sandi akun"
              placeholderTextColor="#94a3b8"
              value={password}
              onChangeText={setPassword}
              secureTextEntry
            />
          </View>

          <TouchableOpacity
            style={[styles.loginBtn, { backgroundColor: colors.primary }]}
            onPress={handleLogin}
            disabled={isLoading}
            activeOpacity={0.8}
          >
            {isLoading ? (
              <ActivityIndicator color="#ffffff" />
            ) : (
              <Text style={styles.loginBtnText}>Masuk ke Portal SDM ➔</Text>
            )}
          </TouchableOpacity>

          {/* Quick Demo Fill Buttons */}
          <View style={styles.demoSection}>
            <Text style={[styles.demoTitle, { color: colors.textLight }]}>Akses Cepat Pengujian Akun:</Text>
            <View style={styles.demoButtonsRow}>
              <TouchableOpacity
                style={[styles.demoBtn, { borderColor: '#10b981' }]}
                onPress={() => handleQuickFill('guru@robbani.sch.id', 'Password@123')}
              >
                <Text style={[styles.demoBtnText, { color: '#059669' }]}>👨‍🏫 Dewan Guru</Text>
              </TouchableOpacity>
              <TouchableOpacity
                style={[styles.demoBtn, { borderColor: '#7c3aed' }]}
                onPress={() => handleQuickFill('admin@smartedu.test', 'p4l3mb4ng')}
              >
                <Text style={[styles.demoBtnText, { color: '#7c3aed' }]}>👑 Super Admin</Text>
              </TouchableOpacity>
            </View>
          </View>

        </View>

        {/* Footer */}
        <Text style={[styles.footerText, { color: colors.textLight }]}>
          © 2026 Yayasan Generasi Robbani Ogan Ilir. All rights reserved.
        </Text>

      </ScrollView>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  scrollContent: {
    flexGrow: 1,
    padding: 24,
    justifyContent: 'center',
  },
  header: {
    alignItems: 'center',
    marginBottom: 24,
  },
  logoCircle: {
    width: 68,
    height: 68,
    borderRadius: 34,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 12,
    shadowColor: '#000',
    shadowOpacity: 0.15,
    shadowRadius: 10,
    elevation: 4,
  },
  logoIcon: {
    fontSize: 32,
  },
  brandTitle: {
    fontSize: 20,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  brandSubtitle: {
    fontSize: 12,
    textAlign: 'center',
    marginTop: 4,
    maxWidth: 280,
    lineHeight: 16,
  },
  unitPillsRow: {
    flexDirection: 'row',
    gap: 6,
    marginTop: 12,
  },
  unitPill: {
    fontSize: 9,
    fontWeight: '900',
    paddingHorizontal: 7,
    paddingVertical: 3,
    borderRadius: 6,
  },
  formCard: {
    padding: 20,
    borderRadius: 24,
    borderWidth: 1,
    shadowColor: '#000',
    shadowOpacity: 0.05,
    shadowRadius: 12,
    elevation: 3,
  },
  formTitle: {
    fontSize: 16,
    fontWeight: '800',
  },
  formSubtitle: {
    fontSize: 12,
    marginTop: 2,
    marginBottom: 16,
  },
  errorBox: {
    backgroundColor: '#fee2e2',
    padding: 10,
    borderRadius: 12,
    marginBottom: 14,
  },
  errorText: {
    color: '#b91c1c',
    fontSize: 12,
    fontWeight: '600',
  },
  inputGroup: {
    marginBottom: 14,
  },
  inputLabel: {
    fontSize: 12,
    fontWeight: '700',
    marginBottom: 6,
  },
  input: {
    paddingHorizontal: 14,
    paddingVertical: 12,
    borderRadius: 14,
    borderWidth: 1,
    fontSize: 13,
  },
  loginBtn: {
    paddingVertical: 14,
    borderRadius: 16,
    alignItems: 'center',
    marginTop: 8,
    shadowColor: '#000',
    shadowOpacity: 0.15,
    shadowRadius: 8,
    elevation: 3,
  },
  loginBtnText: {
    color: '#ffffff',
    fontSize: 14,
    fontWeight: '900',
  },
  demoSection: {
    marginTop: 20,
    paddingTop: 16,
    borderTopWidth: 1,
    borderTopColor: 'rgba(0,0,0,0.06)',
  },
  demoTitle: {
    fontSize: 11,
    fontWeight: '600',
    marginBottom: 8,
    textAlign: 'center',
  },
  demoButtonsRow: {
    flexDirection: 'row',
    gap: 8,
  },
  demoBtn: {
    flex: 1,
    paddingVertical: 8,
    borderRadius: 10,
    borderWidth: 1,
    alignItems: 'center',
    backgroundColor: 'rgba(255,255,255,0.02)',
  },
  demoBtnText: {
    fontSize: 11,
    fontWeight: '800',
  },
  footerText: {
    fontSize: 11,
    textAlign: 'center',
    marginTop: 24,
  },
});
