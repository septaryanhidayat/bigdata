import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  Image,
  Alert,
  Switch,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';

export default function ProfileScreen() {
  const { user, employee, unit, logout } = useAuth();
  const { colors, isDarkMode, toggleDarkMode } = useTheme();

  const handleLogout = () => {
    Alert.alert('Konfirmasi Keluar', 'Apakah Anda yakin ingin keluar dari aplikasi SDM SIT Robbani?', [
      { text: 'Batal', style: 'cancel' },
      { text: 'Keluar', style: 'destructive', onPress: logout },
    ]);
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Profil Pegawai" subtitle="Informasi Akun &amp; Pengaturan" />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Profile Card */}
        <View style={[styles.profileCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Image
            source={{ uri: user?.avatar || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}
            style={[styles.avatarBig, { borderColor: colors.primary }]}
          />
          <Text style={[styles.name, { color: colors.text }]}>{user?.name || 'Ust. Ahmad Dahlan, M.Pd'}</Text>
          <Text style={[styles.position, { color: colors.primary }]}>{employee?.position || 'Pendidik / Tenaga Kependidikan'}</Text>
          <Text style={[styles.nipText, { color: colors.textLight }]}>NIP: {employee?.nip || 'NIP-20260012'}</Text>

          <View style={[styles.unitPill, { backgroundColor: colors.surfaceSub, borderColor: colors.border }]}>
            <Text style={[styles.unitPillText, { color: colors.text }]}>🏫 {unit?.name || 'Yayasan Generasi Robbani'}</Text>
          </View>
        </View>

        {/* Account Info Details */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>Informasi Kepegawaian</Text>
        <View style={[styles.infoCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Email Terdaftar</Text>
            <Text style={[styles.infoVal, { color: colors.text }]}>{user?.email || '-'}</Text>
          </View>
          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Status Kepegawaian</Text>
            <Text style={[styles.infoVal, { color: colors.text }]}>{employee?.employment_status || 'TETAP'}</Text>
          </View>
          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>No. WhatsApp / HP</Text>
            <Text style={[styles.infoVal, { color: colors.text }]}>{employee?.phone || '0812-3456-7890'}</Text>
          </View>
          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Peran Sistem (RBAC)</Text>
            <Text style={[styles.infoVal, { color: colors.primary, fontWeight: '800' }]}>{user?.role_id || 'GURU'}</Text>
          </View>
        </View>

        {/* App Settings */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>Pengaturan Aplikasi</Text>
        <View style={[styles.infoCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <View style={styles.settingRow}>
            <Text style={[styles.settingLabel, { color: colors.text }]}>Mode Gelap (Obsidian Theme)</Text>
            <Switch
              value={isDarkMode}
              onValueChange={toggleDarkMode}
              trackColor={{ false: '#cbd5e1', true: colors.primary }}
              thumbColor="#ffffff"
            />
          </View>
          <TouchableOpacity
            style={styles.settingBtn}
            onPress={() => Alert.alert('Keamanan', 'Fitur ganti kata sandi dapat dilakukan melalui portal web SmartEdu.')}
          >
            <Text style={[styles.settingBtnText, { color: colors.text }]}>🔒 Ganti Kata Sandi</Text>
            <Text style={[styles.arrowText, { color: colors.textLight }]}>➔</Text>
          </TouchableOpacity>
        </View>

        {/* Logout Button */}
        <TouchableOpacity style={styles.logoutBtn} onPress={handleLogout} activeOpacity={0.8}>
          <Text style={styles.logoutBtnText}>🚪 Keluar dari Akun</Text>
        </TouchableOpacity>

        <Text style={[styles.versionText, { color: colors.textLight }]}>
          SDM SIT Robbani Mobile App v1.0.0 (Expo React Native)
        </Text>

      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  scrollContent: {
    padding: 16,
    paddingBottom: 40,
  },
  profileCard: {
    padding: 20,
    borderRadius: 24,
    borderWidth: 1,
    alignItems: 'center',
    marginBottom: 16,
  },
  avatarBig: {
    width: 80,
    height: 80,
    borderRadius: 40,
    borderWidth: 3,
    marginBottom: 12,
  },
  name: {
    fontSize: 16,
    fontWeight: '900',
    textAlign: 'center',
  },
  position: {
    fontSize: 13,
    fontWeight: '800',
    marginTop: 2,
  },
  nipText: {
    fontSize: 11,
    marginTop: 2,
  },
  unitPill: {
    paddingHorizontal: 12,
    paddingVertical: 5,
    borderRadius: 12,
    borderWidth: 1,
    marginTop: 10,
  },
  unitPillText: {
    fontSize: 11,
    fontWeight: '700',
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 8,
    marginTop: 8,
  },
  infoCard: {
    padding: 16,
    borderRadius: 18,
    borderWidth: 1,
    marginBottom: 12,
  },
  infoRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    paddingVertical: 8,
    borderBottomWidth: 0.5,
    borderBottomColor: 'rgba(0,0,0,0.05)',
  },
  infoLabel: {
    fontSize: 12,
  },
  infoVal: {
    fontSize: 12,
    fontWeight: '700',
  },
  settingRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 6,
  },
  settingLabel: {
    fontSize: 13,
    fontWeight: '700',
  },
  settingBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 10,
    marginTop: 6,
    borderTopWidth: 0.5,
    borderTopColor: 'rgba(0,0,0,0.05)',
  },
  settingBtnText: {
    fontSize: 13,
    fontWeight: '700',
  },
  arrowText: {
    fontSize: 12,
  },
  logoutBtn: {
    backgroundColor: '#fee2e2',
    paddingVertical: 14,
    borderRadius: 16,
    alignItems: 'center',
    marginTop: 10,
  },
  logoutBtnText: {
    color: '#b91c1c',
    fontSize: 13,
    fontWeight: '900',
  },
  versionText: {
    fontSize: 10,
    textAlign: 'center',
    marginTop: 20,
  },
});
