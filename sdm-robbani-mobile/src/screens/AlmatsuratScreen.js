import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useTheme } from '../context/ThemeContext';

export default function AlmatsuratScreen({ navigation }) {
  const { colors } = useTheme();
  const [activeTab, setActiveTab] = useState('pagi'); // 'pagi' | 'petang'
  const [counters, setCounters] = useState({});

  const dzikirPagi = [
    {
      id: 'taawudz',
      title: 'Ta\'awwudz & Ayat Kursi',
      targetCount: 1,
      ar: 'أَعُوذُ بِاللَّهِ مِنَ الشَّيْطَانِ الرَّجِيمِ. اللَّهُ لَا إِلَٰهَ إِلَّا هُوَ الْحَيُّ الْقَيُّومُ...',
      latin: 'A\'udzu billahi minasy-syaithanir-rajiim. Allahu laa ilaaha illa huwal hayyul qayyum...',
      idText: 'Aku berlindung kepada Allah dari godaan setan yang terkutuk. Allah, tidak ada tuhan selain Dia, Yang Maha Hidup, yang terus-menerus mengurus (makhluk-Nya)...',
      fadilah: 'Dilindungi oleh Allah dari gangguan setan hingga petang hari.',
    },
    {
      id: 'muawwidzatain',
      title: 'Surah Al-Ikhlas, Al-Falaq, An-Nas',
      targetCount: 3,
      ar: 'قُلْ هُوَ اللَّهُ أَحَدٌ... قُلْ أَعُوذُ بِرَبِّ الْفَلَقِ... قُلْ أَعُوذُ بِرَبِّ النَّاسِ...',
      latin: 'Qul huwallahu ahad... Qul a\'udzu birabbil falaq... Qul a\'udzu birabbin-naas...',
      idText: 'Katakanlah: Dialah Allah, Yang Maha Esa... Katakanlah: Aku berlindung kepada Tuhan Yang Menguasai subuh... Katakanlah: Aku berlindung kepada Tuhan manusia...',
      fadilah: 'Dibaca 3x pada pagi dan petang, akan mencukupkannya dari segala sesuatu (HR. Abu Dawud & Tirmidzi).',
    },
    {
      id: 'ashbahna',
      title: 'Doa Memasuki Pagi Hari',
      targetCount: 1,
      ar: 'أَصْبَحْنَا وَأَصْبَحَ الْمُلْكُ لِلَّهِ، وَالْحَمْدُ لِلَّهِ، لَا إِلَهَ إِلَّا اللَّهُ وَحْدَهُ لَا شَرِيكَ لَهُ...',
      latin: 'Ashbahnaa wa ashbahal mulku lillaahi, walhamdu lillaahi, laa ilaaha illallaahu wahdahu laa syariika lahu...',
      idText: 'Kami telah memasuki waktu pagi dan kerajaan hanya milik Allah, segala puji bagi Allah, tiada sesembahan yang berhak disembah selain Allah Yang Maha Esa, tiada sekutu bagi-Nya...',
      fadilah: 'Mengakui kekuasaan dan kepemilikan Allah atas seluruh alam di awal hari.',
    },
    {
      id: 'sayyidul_istighfar',
      title: 'Sayyidul Istighfar',
      targetCount: 1,
      ar: 'اللَّهُمَّ أَنْتَ رَبِّي لَا إِلَهَ إِلَّا أَنْتَ، خَلَقْتَنِي وَأَنَا عَبْدُكَ، وَأَنَا عَلَى عَهْدِكَ وَوَعْدِكَ مَا اسْتَطَعْتُ...',
      latin: 'Allahumma anta rabbii laa ilaaha illaa anta, khalaqtanii wa anaa \'abduka, wa anaa \'alaa \'ahdika wa wa\'dika mastatha\'tu...',
      idText: 'Ya Allah, Engkaulah Tuhanku, tidak ada tuhan selain Engkau. Engkau yang menciptakan aku dan aku adalah hamba-Mu...',
      fadilah: 'Barangsiapa membacanya di pagi hari dengan penuh keyakinan lalu meninggal sebelum sore, niscaya ia termasuk penghuni surga (HR. Bukhari).',
    },
    {
      id: 'bismillahilladzi',
      title: 'Perlindungan Dari Segala Marabahaya',
      targetCount: 3,
      ar: 'بِسْمِ اللَّهِ الَّذِي لَا يَضُرُّ مَعَ اسْمِهِ شَيْءٌ فِي الْأَرْضِ وَلَا فِي السَّمَاءِ وَهُوَ السَّمِيعُ الْعَلِيمُ',
      latin: 'Bismillaahilladzii laa yadhurru ma\'asmihii syai-un fil ardhi wa laa fis-samaa-i wa huwas-samii\'ul \'aliim',
      idText: 'Dengan nama Allah yang bila bersama nama-Nya tidak ada sesuatupun di bumi maupun di langit yang dapat mendatangkan mudharat, dan Dia Maha Mendengar lagi Maha Mengetahui.',
      fadilah: 'Dibaca 3x, maka tidak akan ada marabahaya atau racun yang mencelakakannya (HR. Abu Dawud & Tirmidzi).',
    },
    {
      id: 'radhitubillah',
      title: 'Keridhaan kepada Allah & Rasulullah',
      targetCount: 3,
      ar: 'رَضِيتُ بِاللَّهِ رَبًّا، وَبِالْإِسْلَامِ دِينًا، وَبِمُحَمَّدٍ صَلَّى اللَّهُ عَلَيْهِ وَسَلَّمَ نَبِيًّا',
      latin: 'Radhiitu billaahi rabbaa, wa bil Islaami diinaa, wa bi Muhammadin shallallaahu \'alayhi wa sallama nabiyyaa',
      idText: 'Aku ridha Allah sebagai Tuhanku, Islam sebagai agamaku, dan Muhammad shallallahu \'alaihi wa sallam sebagai Nabiku.',
      fadilah: 'Wajib bagi Allah untuk meridhai orang yang membacanya 3x di waktu pagi dan petang (HR. Abu Dawud).',
    },
  ];

  const dzikirPetang = [
    {
      id: 'amsayna',
      title: 'Doa Memasuki Waktu Petang',
      targetCount: 1,
      ar: 'أَمْسَيْنَا وَأَمْسَى الْمُلْكُ لِلَّهِ، وَالْحَمْدُ لِلَّهِ، لَا إِلَهَ إِلَّا اللَّهُ وَحْدَهُ لَا شَرِيكَ لَهُ...',
      latin: 'Amsaynaa wa amsal mulku lillaahi, walhamdu lillaahi, laa ilaaha illallaahu wahdahu laa syariika lahu...',
      idText: 'Kami telah memasuki waktu petang dan kerajaan hanya milik Allah, segala puji bagi Allah, tiada sesembahan yang berhak disembah selain Allah Yang Maha Esa...',
      fadilah: 'Menyerahkan jiwa dan penjagaan kepada Allah saat malam menjelang.',
    },
    ...dzikirPagi.filter((d) => d.id !== 'ashbahna'),
  ];

  const currentList = activeTab === 'pagi' ? dzikirPagi : dzikirPetang;

  const handleIncrement = (id, target) => {
    setCounters((prev) => {
      const current = prev[id] || 0;
      const next = current >= target ? target : current + 1;
      return { ...prev, [id]: next };
    });
  };

  const handleReset = (id) => {
    setCounters((prev) => ({ ...prev, [id]: 0 }));
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar
        title="Dzikir Al-Ma'tsurat"
        subtitle="Wirid Doa Pagi &amp; Petang Rasulullah SAW"
        showBack
        onBack={() => navigation?.goBack?.()}
      />

      {/* Tab Switcher Pagi / Petang */}
      <View style={[styles.tabRow, { backgroundColor: colors.surfaceSub }]}>
        <TouchableOpacity
          style={[styles.tabBtn, activeTab === 'pagi' && { backgroundColor: colors.primary }]}
          onPress={() => setActiveTab('pagi')}
        >
          <Text style={[styles.tabBtnText, { color: activeTab === 'pagi' ? '#ffffff' : colors.text }]}>
            🌅 Dzikir Pagi (Shubuh)
          </Text>
        </TouchableOpacity>
        <TouchableOpacity
          style={[styles.tabBtn, activeTab === 'petang' && { backgroundColor: colors.primary }]}
          onPress={() => setActiveTab('petang')}
        >
          <Text style={[styles.tabBtnText, { color: activeTab === 'petang' ? '#ffffff' : colors.text }]}>
            🌇 Dzikir Petang (Ashar)
          </Text>
        </TouchableOpacity>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        {currentList.map((dzikir, idx) => {
          const currentCount = counters[dzikir.id] || 0;
          const isComplete = currentCount >= dzikir.targetCount;

          return (
            <View
              key={dzikir.id}
              style={[
                styles.dzikirCard,
                { backgroundColor: colors.surface, borderColor: isComplete ? '#00dc82' : colors.border },
              ]}
            >
              {/* Header & Target Count */}
              <View style={styles.cardHeader}>
                <View style={[styles.idxCircle, { backgroundColor: colors.surfaceSub }]}>
                  <Text style={[styles.idxText, { color: colors.primary }]}>{idx + 1}</Text>
                </View>
                <Text style={[styles.dzikirTitle, { color: colors.text }]}>{dzikir.title}</Text>
                <View style={[styles.targetBadge, { backgroundColor: isComplete ? '#dcfce7' : colors.surfaceSub }]}>
                  <Text style={[styles.targetBadgeText, { color: isComplete ? '#15803d' : colors.primary }]}>
                    {dzikir.targetCount}x
                  </Text>
                </View>
              </View>

              {/* Arabic */}
              <Text style={[styles.arabicText, { color: colors.text }]}>{dzikir.ar}</Text>

              {/* Latin & Translation */}
              <Text style={[styles.latinText, { color: colors.primary }]}>{dzikir.latin}</Text>
              <Text style={[styles.idText, { color: colors.textLight }]}>{dzikir.idText}</Text>

              {/* Fadilah */}
              {dzikir.fadilah && (
                <View style={[styles.fadilahBox, { backgroundColor: colors.surfaceSub }]}>
                  <Text style={[styles.fadilahText, { color: colors.textLight }]}>
                    💡 <Text style={{ fontWeight: '700' }}>Fadilah:</Text> {dzikir.fadilah}
                  </Text>
                </View>
              )}

              {/* Tasbih Digital Button */}
              <View style={styles.tasbihControlRow}>
                <TouchableOpacity
                  style={[
                    styles.tasbihBtn,
                    { backgroundColor: isComplete ? '#004532' : colors.primary },
                  ]}
                  onPress={() => handleIncrement(dzikir.id, dzikir.targetCount)}
                  activeOpacity={0.7}
                >
                  <Text style={styles.tasbihBtnText}>
                    {isComplete
                      ? `✓ Selesai (${currentCount}/${dzikir.targetCount})`
                      : `📿 Hitung Tasbih: ${currentCount}/${dzikir.targetCount}`}
                  </Text>
                </TouchableOpacity>

                {currentCount > 0 && (
                  <TouchableOpacity style={styles.resetBtn} onPress={() => handleReset(dzikir.id)}>
                    <Text style={[styles.resetBtnText, { color: colors.textLight }]}>🔄 Reset</Text>
                  </TouchableOpacity>
                )}
              </View>

            </View>
          );
        })}
      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  tabRow: {
    flexDirection: 'row',
    marginHorizontal: 16,
    marginTop: 12,
    marginBottom: 8,
    borderRadius: 14,
    padding: 4,
  },
  tabBtn: {
    flex: 1,
    paddingVertical: 10,
    alignItems: 'center',
    borderRadius: 10,
  },
  tabBtnText: {
    fontSize: 12,
    fontWeight: '800',
  },
  scrollContent: {
    padding: 16,
    paddingBottom: 50,
  },
  dzikirCard: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1.5,
    marginBottom: 16,
  },
  cardHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 12,
  },
  idxCircle: {
    width: 28,
    height: 28,
    borderRadius: 14,
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 10,
  },
  idxText: {
    fontSize: 12,
    fontWeight: '900',
  },
  dzikirTitle: {
    flex: 1,
    fontSize: 14,
    fontWeight: '800',
  },
  targetBadge: {
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 8,
  },
  targetBadgeText: {
    fontSize: 11,
    fontWeight: '900',
  },
  arabicText: {
    fontSize: 21,
    lineHeight: 36,
    textAlign: 'right',
    marginBottom: 10,
  },
  latinText: {
    fontSize: 12,
    fontWeight: '700',
    marginBottom: 6,
    lineHeight: 18,
  },
  idText: {
    fontSize: 12,
    lineHeight: 18,
  },
  fadilahBox: {
    padding: 10,
    borderRadius: 12,
    marginTop: 10,
  },
  fadilahText: {
    fontSize: 11,
    lineHeight: 16,
  },
  tasbihControlRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginTop: 14,
    gap: 10,
  },
  tasbihBtn: {
    flex: 1,
    paddingVertical: 12,
    borderRadius: 14,
    alignItems: 'center',
  },
  tasbihBtnText: {
    color: '#ffffff',
    fontSize: 12,
    fontWeight: '900',
  },
  resetBtn: {
    paddingHorizontal: 12,
    paddingVertical: 10,
  },
  resetBtnText: {
    fontSize: 11,
    fontWeight: '700',
  },
});
