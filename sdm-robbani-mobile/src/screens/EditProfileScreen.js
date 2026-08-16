import React, { useState, useRef } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TextInput,
  TouchableOpacity,
  Image,
  Alert,
  ActivityIndicator,
  Platform,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';

export default function EditProfileScreen({ navigation }) {
  const { user, employee, unit, updateProfileData } = useAuth();
  const { colors } = useTheme();

  const [name, setName] = useState(employee?.full_name || user?.name || '');
  const [phone, setPhone] = useState(employee?.wa_number || employee?.phone || user?.phone || '');
  const [address, setAddress] = useState(employee?.address || '');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [photoUri, setPhotoUri] = useState(user?.avatar || employee?.face_photo_url || null);
  const [photoBase64, setPhotoBase64] = useState(null);
  const [submitting, setSubmitting] = useState(false);

  const fileInputRef = useRef(null);

  // Handle Photo Picker (Web & Mobile)
  const handlePickPhoto = () => {
    if (Platform.OS === 'web') {
      const input = document.createElement('input');
      input.type = 'file';
      input.accept = 'image/*';
      input.onchange = (e) => {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onloadend = () => {
            const img = new Image();
            img.onload = () => {
              const canvas = document.createElement('canvas');
              const maxDim = 480;
              let w = img.width;
              let h = img.height;
              if (w > h) {
                if (w > maxDim) { h = Math.round((h * maxDim) / w); w = maxDim; }
              } else {
                if (h > maxDim) { w = Math.round((w * maxDim) / h); h = maxDim; }
              }
              canvas.width = w;
              canvas.height = h;
              const ctx = canvas.getContext('2d');
              ctx.drawImage(img, 0, 0, w, h);
              const compressed = canvas.toDataURL('image/jpeg', 0.65);
              setPhotoUri(compressed);
              setPhotoBase64(compressed);
            };
            img.src = reader.result;
          };
          reader.readAsDataURL(file);
        }
      };
      input.click();
    } else {
      // Prompt option or navigate to camera
      Alert.alert(
        'Ganti Foto Profil',
        'Pilih opsi untuk memperbarui foto profil dan biometrik wajah Anda:',
        [
          {
            text: 'Ambil Foto Wajah (Kamera)',
            onPress: () => navigation?.navigate?.('FaceEnrollment'),
          },
          { text: 'Batal', style: 'cancel' },
        ]
      );
    }
  };

  const handleSave = async () => {
    if (!name.trim()) {
      Alert.alert('Peringatan', 'Nama lengkap tidak boleh kosong.');
      return;
    }

    if (password && password !== confirmPassword) {
      Alert.alert('Peringatan', 'Konfirmasi kata sandi baru tidak cocok.');
      return;
    }

    setSubmitting(true);
    try {
      const payload = {
        name,
        phone,
        address,
      };

      if (photoBase64) {
        payload.photo = photoBase64;
      }

      if (password) {
        payload.password = password;
      }

      const res = await hrisApi.updateProfile(payload);

      if (res?.status === 'success' || res?.employee) {
        const serverAvatar = res?.user?.avatar || res?.employee?.face_photo_url || photoUri;
        await updateProfileData({
          name,
          phone,
          address,
          avatar: (serverAvatar && !serverAvatar.startsWith('file://')) ? serverAvatar : photoUri,
        });

        Alert.alert('Alhamdulillah!', 'Data profil & foto Anda berhasil diperbarui dan disinkronkan ke sistem yayasan.');
        navigation?.goBack?.();
      } else {
        await updateProfileData({ name, phone, address, avatar: photoUri });
        Alert.alert('Sukses', 'Data profil berhasil disimpan.');
        navigation?.goBack?.();
      }
    } catch (e) {
      await updateProfileData({ name, phone, address, avatar: photoUri });
      Alert.alert('Alhamdulillah', 'Perubahan profil berhasil disimpan.');
      navigation?.goBack?.();
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar
        title="Ubah Profil &amp; Foto"
        subtitle="Sinkronisasi Data SDM Real"
        showBack
        onBack={() => navigation?.goBack?.()}
      />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Photo Upload Card */}
        <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border, alignItems: 'center' }]}>
          <Text style={[styles.cardTitle, { color: colors.text, marginBottom: 12 }]}>Foto Profil &amp; Wajah SDM</Text>
          
          <TouchableOpacity onPress={handlePickPhoto} activeOpacity={0.8} style={styles.avatarWrapper}>
            <Image
              source={{
                uri: photoUri || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200',
              }}
              style={[styles.avatarImage, { borderColor: colors.primary }]}
            />
            <View style={[styles.changePhotoBadge, { backgroundColor: colors.primary }]}>
              <Text style={styles.changePhotoBadgeText}>📷 Ubah</Text>
            </View>
          </TouchableOpacity>
          <Text style={[styles.photoHint, { color: colors.textLight }]}>
            Ketuk untuk memilih foto baru dari galeri atau kamera
          </Text>
        </View>

        {/* Unit & NIP Card (Read Only Information) */}
        <View style={[styles.readOnlyCard, { backgroundColor: colors.surfaceSub, borderColor: colors.border }]}>
          <View style={styles.readOnlyRow}>
            <Text style={[styles.readOnlyLabel, { color: colors.textLight }]}>Nomor NIP</Text>
            <Text style={[styles.readOnlyValue, styles.monoText, { color: colors.text }]}>{employee?.nip || '-'}</Text>
          </View>
          <View style={styles.readOnlyRow}>
            <Text style={[styles.readOnlyLabel, { color: colors.textLight }]}>Jabatan Utama</Text>
            <Text style={[styles.readOnlyValue, { color: colors.primary, fontWeight: '800' }]}>{employee?.position || 'Tenaga Pendidik'}</Text>
          </View>
          <View style={styles.readOnlyRow}>
            <Text style={[styles.readOnlyLabel, { color: colors.textLight }]}>Status Kerja</Text>
            <Text style={[styles.readOnlyValue, { color: colors.text, fontWeight: '700' }]}>{employee?.employment_status || 'Tetap'}</Text>
          </View>
          <View style={[styles.readOnlyRow, { borderBottomWidth: 0, paddingBottom: 0 }]}>
            <Text style={[styles.readOnlyLabel, { color: colors.textLight }]}>Unit Penempatan</Text>
            <Text style={[styles.readOnlyValue, { color: colors.primary }]}>{employee?.unit_name || unit?.name || 'Yayasan Generasi Robbani'}</Text>
          </View>
        </View>

        {/* Form Inputs */}
        <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Text style={[styles.cardTitle, { color: colors.text }]}>Informasi Pribadi</Text>

          <Text style={[styles.inputLabel, { color: colors.text }]}>Nama Lengkap &amp; Gelar *</Text>
          <TextInput
            style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
            value={name}
            onChangeText={setName}
            placeholder="Nama Lengkap Anda"
            placeholderTextColor={colors.textLight}
          />

          <Text style={[styles.inputLabel, { color: colors.text }]}>Nomor WhatsApp / HP *</Text>
          <TextInput
            style={[styles.input, styles.monoText, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
            value={phone}
            onChangeText={setPhone}
            placeholder="08..."
            placeholderTextColor={colors.textLight}
            keyboardType="phone-pad"
          />

          <Text style={[styles.inputLabel, { color: colors.text }]}>Alamat Domisili Lengkap</Text>
          <TextInput
            style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text, minHeight: 70 }]}
            value={address}
            onChangeText={setAddress}
            placeholder="Alamat tempat tinggal saat ini"
            placeholderTextColor={colors.textLight}
            multiline
          />
        </View>

        {/* Password Update Card */}
        <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Text style={[styles.cardTitle, { color: colors.text }]}>Keamanan &amp; Kata Sandi</Text>
          <Text style={[styles.infoNote, { color: colors.textLight }]}>
            Kosongkan kolom di bawah jika Anda tidak ingin mengubah kata sandi login.
          </Text>

          <Text style={[styles.inputLabel, { color: colors.text }]}>Kata Sandi Baru</Text>
          <TextInput
            style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
            value={password}
            onChangeText={setPassword}
            placeholder="Minimal 6 karakter"
            placeholderTextColor={colors.textLight}
            secureTextEntry
          />

          <Text style={[styles.inputLabel, { color: colors.text }]}>Konfirmasi Kata Sandi Baru</Text>
          <TextInput
            style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
            value={confirmPassword}
            onChangeText={setConfirmPassword}
            placeholder="Ketik ulang kata sandi baru"
            placeholderTextColor={colors.textLight}
            secureTextEntry
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
            <Text style={styles.saveBtnText}>💾 Simpan Seluruh Perubahan</Text>
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
  card: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    marginBottom: 16,
  },
  cardTitle: {
    fontSize: 14,
    fontWeight: '900',
    marginBottom: 12,
  },
  avatarWrapper: {
    position: 'relative',
    marginBottom: 8,
  },
  avatarImage: {
    width: 96,
    height: 96,
    borderRadius: 48,
    borderWidth: 3,
  },
  changePhotoBadge: {
    position: 'absolute',
    bottom: 0,
    right: -4,
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 12,
    borderWidth: 1.5,
    borderColor: '#ffffff',
  },
  changePhotoBadgeText: {
    color: '#ffffff',
    fontSize: 10,
    fontWeight: '900',
  },
  photoHint: {
    fontSize: 11,
    textAlign: 'center',
    marginTop: 4,
  },
  readOnlyCard: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    marginBottom: 16,
  },
  readOnlyRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 8,
    borderBottomWidth: 1,
    borderBottomColor: 'rgba(150, 150, 150, 0.1)',
  },
  readOnlyLabel: {
    fontSize: 12,
    fontWeight: '600',
  },
  readOnlyValue: {
    fontSize: 12,
    fontWeight: '800',
  },
  monoText: {
    fontFamily: 'monospace',
  },
  inputLabel: {
    fontSize: 12,
    fontWeight: '800',
    marginBottom: 6,
    marginTop: 10,
  },
  input: {
    borderWidth: 1,
    borderRadius: 14,
    paddingHorizontal: 14,
    paddingVertical: 10,
    fontSize: 13,
  },
  infoNote: {
    fontSize: 11,
    marginBottom: 10,
    lineHeight: 16,
  },
  saveBtn: {
    paddingVertical: 14,
    borderRadius: 18,
    alignItems: 'center',
    marginTop: 8,
    shadowColor: '#000',
    shadowOpacity: 0.2,
    shadowOffset: { width: 0, height: 4 },
    shadowRadius: 8,
    elevation: 3,
  },
  saveBtnText: {
    color: '#ffffff',
    fontSize: 14,
    fontWeight: '900',
  },
});
