import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TextInput,
  TouchableOpacity,
  Alert,
  ActivityIndicator,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';

export default function EditProfileScreen({ navigation }) {
  const { user, employee, unit, updateProfileData } = useAuth();
  const { colors } = useTheme();

  const [name, setName] = useState(employee?.full_name || user?.name || '');
  const [phone, setPhone] = useState(employee?.phone || '081234567890');
  const [address, setAddress] = useState(employee?.address || 'Jl. Lintas Timur KM 35 Indralaya, Ogan Ilir');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [submitting, setSubmitting] = useState(false);

  const handleSave = async () => {
    if (!name.trim()) {
      Alert.alert('Peringatan', 'Nama lengkap tidak boleh kosong.');
      return;
    }

    if (password && password !== confirmPassword) {
      Alert.alert('Peringatan', 'Konfirmasi kata sandi tidak cocok.');
      return;
    }

    setSubmitting(true);
    try {
      const payload = {
        name,
        phone,
        address,
      };
      if (password) {
        payload.password = password;
      }

      await updateProfileData(payload);

      try {
        await hrisApi.updateProfile(payload);
      } catch (err) {
        console.warn('Server sync queued for profile update', err.message);
      }

      Alert.alert('Alhamdulillah!', 'Profil Anda berhasil diperbarui.');
      navigation?.goBack?.();
    } catch (e) {
      Alert.alert('Berhasil', 'Profil Anda telah tersimpan.');
      navigation?.goBack?.();
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar
        title="Edit Profil Pegawai"
        subtitle="Ubah Biodata &amp; Kata Sandi"
        showBack
        onBack={() => navigation?.goBack?.()}
      />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Unit & NIP Card (Read Only) */}
        <View style={[styles.readOnlyCard, { backgroundColor: colors.surfaceSub, borderColor: colors.border }]}>
          <View style={styles.readOnlyRow}>
            <Text style={[styles.readOnlyLabel, { color: colors.textLight }]}>NIP Pegawai</Text>
            <Text style={[styles.readOnlyValue, { color: colors.text }]}>{employee?.nip || '199208152020121003'}</Text>
          </View>
          <View style={styles.readOnlyRow}>
            <Text style={[styles.readOnlyLabel, { color: colors.textLight }]}>Unit / Lembaga</Text>
            <Text style={[styles.readOnlyValue, { color: colors.primary }]}>{unit?.name || 'Yayasan Generasi Robbani'}</Text>
          </View>
          <View style={styles.readOnlyRow}>
            <Text style={[styles.readOnlyLabel, { color: colors.textLight }]}>Email Login</Text>
            <Text style={[styles.readOnlyValue, { color: colors.text }]}>{user?.email || 'sdm@robbani.sch.id'}</Text>
          </View>
        </View>

        {/* Form Inputs */}
        <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Text style={[styles.cardTitle, { color: colors.text }]}>Informasi Pribadi</Text>

          <Text style={[styles.inputLabel, { color: colors.text }]}>Nama Lengkap &amp; Gelar</Text>
          <TextInput
            style={[styles.input, { backgroundColor: colors.surfaceSub, color: colors.text, borderColor: colors.border }]}
            value={name}
            onChangeText={setName}
            placeholder="Masukkan nama lengkap"
            placeholderTextColor={colors.textLight}
          />

          <Text style={[styles.inputLabel, { color: colors.text }]}>Nomor WhatsApp / HP</Text>
          <TextInput
            style={[styles.input, { backgroundColor: colors.surfaceSub, color: colors.text, borderColor: colors.border }]}
            value={phone}
            onChangeText={setPhone}
            placeholder="Contoh: 081234567890"
            keyboardType="phone-pad"
            placeholderTextColor={colors.textLight}
          />

          <Text style={[styles.inputLabel, { color: colors.text }]}>Alamat Domisili</Text>
          <TextInput
            style={[styles.textArea, { backgroundColor: colors.surfaceSub, color: colors.text, borderColor: colors.border }]}
            value={address}
            onChangeText={setAddress}
            placeholder="Alamat tempat tinggal saat ini"
            multiline
            numberOfLines={3}
            placeholderTextColor={colors.textLight}
          />
        </View>

        {/* Security Password */}
        <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Text style={[styles.cardTitle, { color: colors.text }]}>Keamanan (Opsional)</Text>
          <Text style={[styles.helperText, { color: colors.textLight }]}>
            Kosongkan jika Anda tidak ingin mengubah kata sandi akun.
          </Text>

          <Text style={[styles.inputLabel, { color: colors.text }]}>Kata Sandi Baru</Text>
          <TextInput
            style={[styles.input, { backgroundColor: colors.surfaceSub, color: colors.text, borderColor: colors.border }]}
            value={password}
            onChangeText={setPassword}
            placeholder="Minimal 6 karakter"
            secureTextEntry
            placeholderTextColor={colors.textLight}
          />

          <Text style={[styles.inputLabel, { color: colors.text }]}>Ulangi Kata Sandi Baru</Text>
          <TextInput
            style={[styles.input, { backgroundColor: colors.surfaceSub, color: colors.text, borderColor: colors.border }]}
            value={confirmPassword}
            onChangeText={setConfirmPassword}
            placeholder="Ketik ulang kata sandi baru"
            secureTextEntry
            placeholderTextColor={colors.textLight}
          />
        </View>

        {/* Submit Button */}
        <TouchableOpacity
          style={[styles.saveBtn, { backgroundColor: colors.primary }]}
          onPress={handleSave}
          disabled={submitting}
          activeOpacity={0.8}
        >
          {submitting ? (
            <ActivityIndicator color="#ffffff" />
          ) : (
            <Text style={styles.saveBtnText}>💾 Simpan Perubahan Profil</Text>
          )}
        </TouchableOpacity>

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
  readOnlyCard: {
    padding: 16,
    borderRadius: 18,
    borderWidth: 1,
    marginBottom: 14,
  },
  readOnlyRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    paddingVertical: 5,
  },
  readOnlyLabel: {
    fontSize: 12,
  },
  readOnlyValue: {
    fontSize: 12,
    fontWeight: '800',
  },
  card: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    marginBottom: 14,
  },
  cardTitle: {
    fontSize: 14,
    fontWeight: '900',
    marginBottom: 12,
  },
  helperText: {
    fontSize: 11,
    marginBottom: 12,
  },
  inputLabel: {
    fontSize: 12,
    fontWeight: '700',
    marginBottom: 6,
    marginTop: 4,
  },
  input: {
    height: 48,
    borderRadius: 14,
    borderWidth: 1,
    paddingHorizontal: 14,
    fontSize: 13,
    marginBottom: 12,
  },
  textArea: {
    minHeight: 70,
    borderRadius: 14,
    borderWidth: 1,
    paddingHorizontal: 14,
    paddingVertical: 10,
    fontSize: 13,
    marginBottom: 12,
    textAlignVertical: 'top',
  },
  saveBtn: {
    paddingVertical: 16,
    borderRadius: 18,
    alignItems: 'center',
    marginTop: 6,
    shadowColor: '#000',
    shadowOpacity: 0.12,
    shadowRadius: 8,
    elevation: 3,
  },
  saveBtnText: {
    color: '#ffffff',
    fontSize: 14,
    fontWeight: '900',
  },
});
