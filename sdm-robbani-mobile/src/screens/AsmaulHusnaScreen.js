import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TextInput,
  TouchableOpacity,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useTheme } from '../context/ThemeContext';

export default function AsmaulHusnaScreen({ navigation }) {
  const { colors } = useTheme();
  const [search, setSearch] = useState('');

  const names = [
    { num: 1, latin: 'Ar-Rahman', ar: 'الرَّحْمَنُ', meaning: 'Yang Maha Pengasih' },
    { num: 2, latin: 'Ar-Rahim', ar: 'الرَّحِيمُ', meaning: 'Yang Maha Penyayang' },
    { num: 3, latin: 'Al-Malik', ar: 'الْمَلِكُ', meaning: 'Yang Maha Merajai' },
    { num: 4, latin: 'Al-Quddus', ar: 'الْقُدُّوسُ', meaning: 'Yang Maha Suci' },
    { num: 5, latin: 'As-Salam', ar: 'السَّلاَمُ', meaning: 'Yang Maha Memberi Kesejahteraan' },
    { num: 6, latin: 'Al-Mu\'min', ar: 'الْمُؤْمِنُ', meaning: 'Yang Maha Memberi Keamanan' },
    { num: 7, latin: 'Al-Muhaimin', ar: 'الْمُهَيْمِنُ', meaning: 'Yang Maha Memelihara' },
    { num: 8, latin: 'Al-\'Aziz', ar: 'الْعَزِيزُ', meaning: 'Yang Maha Perkasa' },
    { num: 9, latin: 'Al-Jabbar', ar: 'الْجَبَّارُ', meaning: 'Yang Memiliki Mutlak Kegagahan' },
    { num: 10, latin: 'Al-Mutakabbir', ar: 'الْمُتَكَبِّرُ', meaning: 'Yang Maha Megah / Memiliki Kebesaran' },
    { num: 11, latin: 'Al-Khaliq', ar: 'الْخَالِقُ', meaning: 'Yang Maha Pencipta' },
    { num: 12, latin: 'Al-Bari\'', ar: 'الْبَارِئُ', meaning: 'Yang Maha Melepaskan / Membuat' },
    { num: 13, latin: 'Al-Mushawwir', ar: 'الْمُصَوِّرُ', meaning: 'Yang Maha Membentuk Rupa' },
    { num: 14, latin: 'Al-Ghaffar', ar: 'الْغَفَّارُ', meaning: 'Yang Maha Pengampun' },
    { num: 15, latin: 'Al-Qahhar', ar: 'الْقَهَّارُ', meaning: 'Yang Maha Memaksa / Mengalahkan' },
    { num: 16, latin: 'Al-Wahhab', ar: 'الْوَهَّابُ', meaning: 'Yang Maha Pemberi Karunia' },
    { num: 17, latin: 'Ar-Razzaq', ar: 'الرَّزَّاقُ', meaning: 'Yang Maha Pemberi Rezeki' },
    { num: 18, latin: 'Al-Fattah', ar: 'الْفَتَّاحُ', meaning: 'Yang Maha Pembuka Rahmat' },
    { num: 19, latin: 'Al-\'Alim', ar: 'الْعَلِيمُ', meaning: 'Yang Maha Mengetahui' },
    { num: 20, latin: 'Al-Qabidh', ar: 'الْقَابِضُ', meaning: 'Yang Maha Menyempitkan' },
    { num: 21, latin: 'Al-Basith', ar: 'الْبَاسِطُ', meaning: 'Yang Maha Melapangkan' },
    { num: 22, latin: 'Al-Khafidz', ar: 'الْخَافِضُ', meaning: 'Yang Maha Merendahkan' },
    { num: 23, latin: 'Ar-Rafi\'', ar: 'الرَّافِعُ', meaning: 'Yang Maha Meninggikan' },
    { num: 24, latin: 'Al-Mu\'izz', ar: 'الْمُعِزُّ', meaning: 'Yang Maha Memuliakan' },
    { num: 25, latin: 'Al-Mudzill', ar: 'المُذِلُّ', meaning: 'Yang Maha Menghinakan' },
    { num: 26, latin: 'As-Sami\'', ar: 'السَّمِيعُ', meaning: 'Yang Maha Mendengar' },
    { num: 27, latin: 'Al-Bashir', ar: 'الْبَصِيرُ', meaning: 'Yang Maha Melihat' },
    { num: 28, latin: 'Al-Hakam', ar: 'الْحَكَمُ', meaning: 'Yang Maha Menetapkan Hukum' },
    { num: 29, latin: 'Al-\'Adl', ar: 'الْعَدْلُ', meaning: 'Yang Maha Adil' },
    { num: 30, latin: 'Al-Lathif', ar: 'اللَّطِيفُ', meaning: 'Yang Maha Lembut' },
    { num: 31, latin: 'Al-Khabir', ar: 'الْخَبِيرُ', meaning: 'Yang Maha Mengenal' },
    { num: 32, latin: 'Al-Halim', ar: 'الْحَلِيمُ', meaning: 'Yang Maha Penyantun' },
    { num: 33, latin: 'Al-\'Azhim', ar: 'الْعَظِيمُ', meaning: 'Yang Maha Agung' },
    { num: 34, latin: 'Al-Ghafur', ar: 'الْغَفُورُ', meaning: 'Yang Maha Pengampun' },
    { num: 35, latin: 'Asy-Syakur', ar: 'الشَّكُورُ', meaning: 'Yang Maha Menghargai' },
    { num: 36, latin: 'Al-\'Aliyy', ar: 'الْعَلِيُّ', meaning: 'Yang Maha Tinggi' },
    { num: 37, latin: 'Al-Kabir', ar: 'الْكَبِيرُ', meaning: 'Yang Maha Besar' },
    { num: 38, latin: 'Al-Hafizh', ar: 'الْحَفِيظُ', meaning: 'Yang Maha Memelihara' },
    { num: 39, latin: 'Al-Muqit', ar: 'المُقيِت', meaning: 'Yang Maha Pemberi Kecukupan' },
    { num: 40, latin: 'Al-Hasib', ar: 'الْحسِيبُ', meaning: 'Yang Maha Membuat Perhitungan' },
  ];

  const filtered = names.filter((n) =>
    n.latin.toLowerCase().includes(search.toLowerCase()) ||
    n.meaning.toLowerCase().includes(search.toLowerCase()) ||
    n.num.toString().includes(search)
  );

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar
        title="Asmaul Husna"
        subtitle="99 Nama-Nama Agung &amp; Indah Allah SWT"
        showBack
        onBack={() => navigation?.goBack?.()}
      />

      <View style={[styles.searchBox, { backgroundColor: colors.surface, borderColor: colors.border }]}>
        <Text style={styles.searchIcon}>🔍</Text>
        <TextInput
          style={[styles.searchInput, { color: colors.text }]}
          value={search}
          onChangeText={setSearch}
          placeholder="Cari Asmaul Husna (contoh: Ar-Rahman, Pengasih)..."
          placeholderTextColor={colors.textLight}
        />
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        <View style={styles.gridContainer}>
          {filtered.map((item) => (
            <View
              key={item.num}
              style={[styles.nameCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
            >
              <View style={styles.cardTop}>
                <View style={[styles.numBadge, { backgroundColor: colors.surfaceSub }]}>
                  <Text style={[styles.numText, { color: colors.primary }]}>{item.num}</Text>
                </View>
                <Text style={[styles.arabicText, { color: colors.primary }]}>{item.ar}</Text>
              </View>
              <Text style={[styles.latinText, { color: colors.text }]}>{item.latin}</Text>
              <Text style={[styles.meaningText, { color: colors.textLight }]}>{item.meaning}</Text>
            </View>
          ))}
        </View>
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  searchBox: {
    flexDirection: 'row',
    alignItems: 'center',
    marginHorizontal: 16,
    marginTop: 12,
    marginBottom: 8,
    paddingHorizontal: 14,
    height: 46,
    borderRadius: 14,
    borderWidth: 1,
  },
  searchIcon: {
    fontSize: 16,
    marginRight: 8,
  },
  searchInput: {
    flex: 1,
    fontSize: 13,
  },
  scrollContent: {
    padding: 16,
    paddingBottom: 40,
  },
  gridContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 10,
    justifyContent: 'space-between',
  },
  nameCard: {
    width: '48%',
    padding: 14,
    borderRadius: 18,
    borderWidth: 1,
    marginBottom: 4,
  },
  cardTop: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 8,
  },
  numBadge: {
    width: 26,
    height: 26,
    borderRadius: 13,
    alignItems: 'center',
    justifyContent: 'center',
  },
  numText: {
    fontSize: 11,
    fontWeight: '900',
  },
  arabicText: {
    fontSize: 20,
    fontWeight: 'bold',
  },
  latinText: {
    fontSize: 13,
    fontWeight: '900',
    marginBottom: 2,
  },
  meaningText: {
    fontSize: 11,
    lineHeight: 15,
  },
});
