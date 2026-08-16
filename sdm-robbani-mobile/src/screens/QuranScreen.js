import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  TextInput,
  Modal,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useTheme } from '../context/ThemeContext';

export default function QuranScreen({ navigation }) {
  const { colors } = useTheme();
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedSurah, setSelectedSurah] = useState(null);

  const surahs = [
    { number: 1, name: 'Al-Fatihah', arabic: 'الفاتحة', meaning: 'Pembukaan', verses: 7, type: 'Makkiyah' },
    { number: 2, name: 'Al-Baqarah', arabic: 'البقرة', meaning: 'Sapi Betina', verses: 286, type: 'Madaniyah' },
    { number: 3, name: 'Ali \'Imran', arabic: 'آل عمران', meaning: 'Keluarga Imran', verses: 200, type: 'Madaniyah' },
    { number: 4, name: 'An-Nisa\'', arabic: 'النساء', meaning: 'Wanita', verses: 176, type: 'Madaniyah' },
    { number: 5, name: 'Al-Ma\'idah', arabic: 'المائدة', meaning: 'Hidangan', verses: 120, type: 'Madaniyah' },
    { number: 18, name: 'Al-Kahf', arabic: 'الكهف', meaning: 'Penghuni Gua', verses: 110, type: 'Makkiyah' },
    { number: 36, name: 'Ya Sin', arabic: 'يس', meaning: 'Yasin', verses: 83, type: 'Makkiyah' },
    { number: 55, name: 'Ar-Rahman', arabic: 'الرحمن', meaning: 'Yang Maha Pemurah', verses: 78, type: 'Madaniyah' },
    { number: 56, name: 'Al-Waqi\'ah', arabic: 'الواقعة', meaning: 'Hari Kiamat', verses: 96, type: 'Makkiyah' },
    { number: 67, name: 'Al-Mulk', arabic: 'الملك', meaning: 'Kerajaan', verses: 30, type: 'Makkiyah' },
    { number: 78, name: 'An-Naba\'', arabic: 'النبإ', meaning: 'Berita Besar', verses: 40, type: 'Makkiyah' },
    { number: 93, name: 'Ad-Duha', arabic: 'الضحى', meaning: 'Waktu Duha', verses: 11, type: 'Makkiyah' },
    { number: 94, name: 'Asy-Syarh', arabic: 'الشرح', meaning: 'Kelapangan', verses: 8, type: 'Makkiyah' },
    { number: 97, name: 'Al-Qadr', arabic: 'القدر', meaning: 'Kemuliaan', verses: 5, type: 'Makkiyah' },
    { number: 108, name: 'Al-Kautsar', arabic: 'الكوثر', meaning: 'Nikmat Berlimpah', verses: 3, type: 'Makkiyah' },
    { number: 112, name: 'Al-Ikhlas', arabic: 'الإخلاص', meaning: 'Memurnikan Keesaan Allah', verses: 4, type: 'Makkiyah' },
    { number: 113, name: 'Al-Falaq', arabic: 'الفلق', meaning: 'Waktu Subuh', verses: 5, type: 'Makkiyah' },
    { number: 114, name: 'An-Nas', arabic: 'الناس', meaning: 'Manusia', verses: 6, type: 'Makkiyah' },
  ];

  const sampleAyahs = [
    { num: 1, ar: 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', latin: 'Bismillaahir-rahmaanir-raheem', id: 'Dengan nama Allah Yang Maha Pengasih, Maha Penyayang.' },
    { num: 2, ar: 'الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ', latin: 'Al-hamdu lillaahi Rabbil-\'aalameen', id: 'Segala puji bagi Allah, Tuhan seluruh alam.' },
    { num: 3, ar: 'الرَّحْمَٰنِ الرَّحِيمِ', latin: 'Ar-Rahmaanir-Raheem', id: 'Yang Maha Pengasih, Maha Penyayang.' },
    { num: 4, ar: 'مَالِكِ يَوْمِ الدِّينِ', latin: 'Maaliki Yawmid-Deen', id: 'Pemilik hari pembalasan.' },
    { num: 5, ar: 'إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ', latin: 'Iyyaaka na\'budu wa lyyaaka nasta\'een', id: 'Hanya kepada Engkaulah kami menyembah dan hanya kepada Engkaulah kami mohon pertolongan.' },
    { num: 6, ar: 'اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ', latin: 'Ihdinas-Siraatal-Mustaqeem', id: 'Tunjukilah kami jalan yang lurus,' },
    { num: 7, ar: 'صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ', latin: 'Siraatal-lazeena an\'amta \'alayhim ghayril-maghdoobi \'alayhim wa lad-daalleen', id: '(yaitu) jalan orang-orang yang telah Engkau beri nikmat kepadanya; bukan (jalan) mereka yang dimurkai, dan bukan (pula jalan) mereka yang sesat.' },
  ];

  const filteredSurahs = surahs.filter((s) =>
    s.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
    s.meaning.toLowerCase().includes(searchQuery.toLowerCase()) ||
    s.number.toString().includes(searchQuery)
  );

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar
        title="Al-Qur'an Digital"
        subtitle="30 Juz &amp; Terjemahan Bahasa Indonesia"
        showBack
        onBack={() => navigation?.goBack?.()}
      />

      {/* Search Input */}
      <View style={[styles.searchBox, { backgroundColor: colors.surface, borderColor: colors.border }]}>
        <Text style={styles.searchIcon}>🔍</Text>
        <TextInput
          style={[styles.searchInput, { color: colors.text }]}
          value={searchQuery}
          onChangeText={setSearchQuery}
          placeholder="Cari nama surah atau nomor (misal: Yasin, Al-Kahf)..."
          placeholderTextColor={colors.textLight}
        />
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Quick Surah Shortcut */}
        <View style={styles.shortcutRow}>
          {['Al-Kahf', 'Ya Sin', 'Al-Mulk', 'Al-Waqi\'ah'].map((fav) => (
            <TouchableOpacity
              key={fav}
              style={[styles.shortcutPill, { backgroundColor: colors.surfaceSub, borderColor: colors.border }]}
              onPress={() => setSearchQuery(fav)}
            >
              <Text style={[styles.shortcutPillText, { color: colors.primary }]}>✨ {fav}</Text>
            </TouchableOpacity>
          ))}
        </View>

        {/* Surah List */}
        {filteredSurahs.map((surah) => (
          <TouchableOpacity
            key={surah.number}
            style={[styles.surahCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
            onPress={() => setSelectedSurah(surah)}
            activeOpacity={0.75}
          >
            <View style={[styles.numberCircle, { backgroundColor: colors.primary }]}>
              <Text style={styles.numberText}>{surah.number}</Text>
            </View>

            <View style={styles.surahInfo}>
              <Text style={[styles.surahName, { color: colors.text }]}>{surah.name}</Text>
              <Text style={[styles.surahMeaning, { color: colors.textLight }]}>
                {surah.meaning} • {surah.verses} Ayat ({surah.type})
              </Text>
            </View>

            <Text style={[styles.surahArabic, { color: colors.primary }]}>{surah.arabic}</Text>
          </TouchableOpacity>
        ))}

      </ScrollView>

      {/* Surah Detail Modal Reader */}
      <Modal visible={Boolean(selectedSurah)} animationType="slide" onRequestClose={() => setSelectedSurah(null)}>
        <View style={[styles.modalContainer, { backgroundColor: colors.bg }]}>
          <View style={[styles.modalHeader, { backgroundColor: '#004532' }]}>
            <TouchableOpacity onPress={() => setSelectedSurah(null)} style={styles.closeBtn}>
              <Text style={styles.closeBtnText}>‹ Kembali</Text>
            </TouchableOpacity>
            <Text style={styles.modalHeaderTitle}>Surah {selectedSurah?.name}</Text>
            <Text style={styles.modalHeaderArabic}>{selectedSurah?.arabic}</Text>
          </View>

          <ScrollView contentContainerStyle={styles.ayahsScroll}>
            <View style={styles.bismillahBox}>
              <Text style={styles.bismillahArabic}>بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</Text>
              <Text style={[styles.bismillahLatin, { color: colors.textLight }]}>
                Dengan nama Allah Yang Maha Pengasih, Maha Penyayang
              </Text>
            </View>

            {sampleAyahs.map((ayah) => (
              <View key={ayah.num} style={[styles.ayahCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
                <View style={styles.ayahNumberRow}>
                  <View style={[styles.ayahPill, { backgroundColor: colors.surfaceSub }]}>
                    <Text style={[styles.ayahPillText, { color: colors.primary }]}>Ayat {ayah.num}</Text>
                  </View>
                </View>
                <Text style={[styles.ayahArabic, { color: colors.text }]}>{ayah.ar}</Text>
                <Text style={[styles.ayahLatin, { color: colors.primary }]}>{ayah.latin}</Text>
                <Text style={[styles.ayahId, { color: colors.textLight }]}>{ayah.id}</Text>
              </View>
            ))}
          </ScrollView>
        </View>
      </Modal>
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
    paddingHorizontal: 16,
    paddingBottom: 40,
  },
  shortcutRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 6,
    marginVertical: 8,
  },
  shortcutPill: {
    paddingHorizontal: 10,
    paddingVertical: 5,
    borderRadius: 10,
    borderWidth: 1,
  },
  shortcutPillText: {
    fontSize: 11,
    fontWeight: '800',
  },
  surahCard: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: 14,
    borderRadius: 18,
    borderWidth: 1,
    marginBottom: 10,
  },
  numberCircle: {
    width: 36,
    height: 36,
    borderRadius: 18,
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 12,
  },
  numberText: {
    color: '#ffffff',
    fontSize: 12,
    fontWeight: '900',
  },
  surahInfo: {
    flex: 1,
  },
  surahName: {
    fontSize: 14,
    fontWeight: '800',
  },
  surahMeaning: {
    fontSize: 11,
    marginTop: 2,
  },
  surahArabic: {
    fontSize: 20,
    fontWeight: 'bold',
  },
  modalContainer: {
    flex: 1,
  },
  modalHeader: {
    paddingTop: 44,
    paddingBottom: 16,
    paddingHorizontal: 16,
    alignItems: 'center',
  },
  closeBtn: {
    alignSelf: 'flex-start',
    paddingVertical: 4,
    paddingHorizontal: 8,
    marginBottom: 6,
  },
  closeBtnText: {
    color: '#ffffff',
    fontSize: 14,
    fontWeight: '800',
  },
  modalHeaderTitle: {
    color: '#ffffff',
    fontSize: 18,
    fontWeight: '900',
  },
  modalHeaderArabic: {
    color: '#c6f634',
    fontSize: 22,
    marginTop: 2,
  },
  ayahsScroll: {
    padding: 16,
    paddingBottom: 50,
  },
  bismillahBox: {
    alignItems: 'center',
    paddingVertical: 18,
    marginBottom: 16,
  },
  bismillahArabic: {
    fontSize: 24,
    color: '#059669',
    fontWeight: 'bold',
    marginBottom: 6,
  },
  bismillahLatin: {
    fontSize: 12,
    fontStyle: 'italic',
  },
  ayahCard: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    marginBottom: 14,
  },
  ayahNumberRow: {
    flexDirection: 'row',
    marginBottom: 10,
  },
  ayahPill: {
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 8,
  },
  ayahPillText: {
    fontSize: 11,
    fontWeight: '900',
  },
  ayahArabic: {
    fontSize: 22,
    lineHeight: 38,
    textAlign: 'right',
    marginBottom: 10,
  },
  ayahLatin: {
    fontSize: 12,
    fontWeight: '700',
    marginBottom: 4,
    lineHeight: 18,
  },
  ayahId: {
    fontSize: 12,
    lineHeight: 18,
  },
});
