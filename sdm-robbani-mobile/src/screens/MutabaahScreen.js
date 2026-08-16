import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  TextInput,
  Switch,
  Alert,
  ActivityIndicator,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';
import { formatDateIndonesia } from '../utils/formatters';

export default function MutabaahScreen({ navigation }) {
  const { colors } = useTheme();

  const [loading, setLoading] = useState(true);
  const [submitting, setSubmitting] = useState(false);
  const [scorePercentage, setScorePercentage] = useState(85);

  // Form Mutabaah State
  const [fardhuCount, setFardhuCount] = useState(5);
  const [rawatib, setRawatib] = useState(true);
  const [tahajjud, setTahajjud] = useState(true);
  const [dhuha, setDhuha] = useState(true);
  const [tilawahPages, setTilawahPages] = useState('4');
  const [matsurat, setMatsurat] = useState('lengkap'); // none, pagi, petang, lengkap
  const [puasa, setPuasa] = useState(false);
  const [infaq, setInfaq] = useState(true);
  const [bacaBuku, setBacaBuku] = useState(true);
  const [notes, setNotes] = useState('');

  // Tab State
  const [activeTab, setActiveTab] = useState('today'); // 'today' | 'history'
  const [historyList, setHistoryList] = useState([]);

  const fetchTodayMutabaah = async () => {
    try {
      const res = await hrisApi.getTodayMutabaah();
      if (res.status === 'success' && res.data) {
        const d = res.data;
        setFardhuCount(d.sholat_fardhu_jamaah ?? 5);
        setRawatib(Boolean(d.sholat_rawatib));
        setTahajjud(Boolean(d.sholat_tahajjud));
        setDhuha(Boolean(d.sholat_dhuha));
        setTilawahPages(String(d.tilawah_pages ?? 4));
        setMatsurat(d.al_matsurat ?? 'lengkap');
        setPuasa(Boolean(d.puasa_sunnah));
        setInfaq(Boolean(d.infaq));
        setBacaBuku(Boolean(d.baca_buku));
        setNotes(d.notes ?? '');
        if (res.score_percentage) setScorePercentage(res.score_percentage);
      }
    } catch (e) {
      console.error('Error fetching today mutabaah', e);
    } finally {
      setLoading(false);
    }
  };

  const fetchHistory = async () => {
    try {
      const res = await hrisApi.getMutabaahHistory();
      if (res.status === 'success') {
        setHistoryList(res.data || []);
      }
    } catch (e) {
      console.error('Error fetching history', e);
    }
  };

  useEffect(() => {
    fetchTodayMutabaah();
    fetchHistory();
  }, []);

  const calculateLiveScore = () => {
    let score = 0;
    if (fardhuCount >= 5) score += 30;
    else if (fardhuCount >= 3) score += 20;
    if (rawatib) score += 10;
    if (tahajjud) score += 15;
    if (dhuha) score += 10;
    if (parseInt(tilawahPages, 10) >= 4) score += 15;
    else if (parseInt(tilawahPages, 10) > 0) score += 10;
    if (matsurat === 'lengkap') score += 10;
    else if (matsurat !== 'none') score += 5;
    if (infaq) score += 5;
    if (bacaBuku) score += 5;
    return Math.min(100, score);
  };

  const handleSave = async () => {
    setSubmitting(true);
    try {
      const payload = {
        sholat_fardhu_jamaah: fardhuCount,
        sholat_rawatib: rawatib,
        sholat_tahajjud: tahajjud,
        sholat_dhuha: dhuha,
        tilawah_pages: parseInt(tilawahPages, 10) || 0,
        al_matsurat: matsurat,
        puasa_sunnah: puasa,
        infaq: infaq,
        baca_buku: bacaBuku,
        notes: notes.trim(),
      };

      const res = await hrisApi.saveTodayMutabaah(payload);
      if (res.status === 'success') {
        Alert.alert('Alhamdulillah', res.message);
        setScorePercentage(calculateLiveScore());
        fetchHistory();
      } else {
        Alert.alert('Gagal', res.message);
      }
    } catch (e) {
      Alert.alert('Error', 'Gagal menyimpan laporan mutabaah.');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Amal Ibadah Harian" subtitle="Mutabaah Yaumiyah SDM Robbani" />

      {/* Tab Selector */}
      <View style={[styles.tabBar, { backgroundColor: colors.surface, borderBottomColor: colors.border }]}>
        <TouchableOpacity
          style={[styles.tabBtn, activeTab === 'today' && { borderBottomColor: colors.primary, borderBottomWidth: 3 }]}
          onPress={() => setActiveTab('today')}
        >
          <Text style={[styles.tabText, { color: activeTab === 'today' ? colors.primary : colors.textLight }]}>
            📝 Input Hari Ini
          </Text>
        </TouchableOpacity>

        <TouchableOpacity
          style={[styles.tabBtn, activeTab === 'history' && { borderBottomColor: colors.primary, borderBottomWidth: 3 }]}
          onPress={() => setActiveTab('history')}
        >
          <Text style={[styles.tabText, { color: activeTab === 'history' ? colors.primary : colors.textLight }]}>
            📊 Riwayat Ibadah
          </Text>
        </TouchableOpacity>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {activeTab === 'today' ? (
          <>
            {/* Score Hero Banner */}
            <View style={[styles.scoreHero, { backgroundColor: colors.primary }]}>
              <View style={styles.scoreLeft}>
                <Text style={styles.scoreBadge}>CAPAIAN IBADAH YAUMIYAH HARI INI</Text>
                <Text style={styles.scoreValue}>{calculateLiveScore()}%</Text>
                <Text style={styles.scoreDesc}>
                  {calculateLiveScore() >= 80 ? '🌟 Sangat Istiqomah (Mumtaz)' : 'Semangat Tingkatkan Target Yaumiyah!'}
                </Text>
              </View>
              <View style={styles.scoreRightCircle}>
                <Text style={styles.scoreIcon}>🕌</Text>
              </View>
            </View>

            {/* Form Checklist Items */}
            <Text style={[styles.sectionTitle, { color: colors.text }]}>Checklist Amalan Yaumiyah</Text>

            {/* 1. Sholat Fardhu Berjamaah */}
            <View style={[styles.checkCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <View style={styles.checkCardHeader}>
                <Text style={styles.itemIcon}>🕌</Text>
                <View style={styles.itemTextContainer}>
                  <Text style={[styles.itemTitle, { color: colors.text }]}>Sholat Fardhu Berjamaah di Masjid</Text>
                  <Text style={[styles.itemSubtitle, { color: colors.textLight }]}>Target: 5 Waktu (Subuh s/d Isya)</Text>
                </View>
              </View>
              <View style={styles.counterRow}>
                {[0, 1, 2, 3, 4, 5].map((num) => (
                  <TouchableOpacity
                    key={num}
                    style={[
                      styles.counterBtn,
                      {
                        backgroundColor: fardhuCount === num ? colors.primary : colors.surfaceSub,
                        borderColor: colors.border,
                      },
                    ]}
                    onPress={() => setFardhuCount(num)}
                  >
                    <Text style={[styles.counterBtnText, { color: fardhuCount === num ? '#fff' : colors.text }]}>
                      {num} Waktu
                    </Text>
                  </TouchableOpacity>
                ))}
              </View>
            </View>

            {/* 2. Sholat Sunnah Rawatib */}
            <View style={[styles.toggleCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <View style={styles.toggleLeft}>
                <Text style={styles.itemIcon}>📿</Text>
                <View>
                  <Text style={[styles.itemTitle, { color: colors.text }]}>Sholat Sunnah Rawatib</Text>
                  <Text style={[styles.itemSubtitle, { color: colors.textLight }]}>Qobliyah &amp; Ba'diyah</Text>
                </View>
              </View>
              <Switch
                value={rawatib}
                onValueChange={setRawatib}
                trackColor={{ false: '#cbd5e1', true: colors.primary }}
                thumbColor="#ffffff"
              />
            </View>

            {/* 3. Qiyamul Lail / Tahajjud */}
            <View style={[styles.toggleCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <View style={styles.toggleLeft}>
                <Text style={styles.itemIcon}>🌙</Text>
                <View>
                  <Text style={[styles.itemTitle, { color: colors.text }]}>Qiyamul Lail (Tahajjud &amp; Witir)</Text>
                  <Text style={[styles.itemSubtitle, { color: colors.textLight }]}>Minimal 2 rakaat + 1 witir</Text>
                </View>
              </View>
              <Switch
                value={tahajjud}
                onValueChange={setTahajjud}
                trackColor={{ false: '#cbd5e1', true: colors.primary }}
                thumbColor="#ffffff"
              />
            </View>

            {/* 4. Sholat Dhuha */}
            <View style={[styles.toggleCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <View style={styles.toggleLeft}>
                <Text style={styles.itemIcon}>☀️</Text>
                <View>
                  <Text style={[styles.itemTitle, { color: colors.text }]}>Sholat Dhuha</Text>
                  <Text style={[styles.itemSubtitle, { color: colors.textLight }]}>2 hingga 8 rakaat</Text>
                </View>
              </View>
              <Switch
                value={dhuha}
                onValueChange={setDhuha}
                trackColor={{ false: '#cbd5e1', true: colors.primary }}
                thumbColor="#ffffff"
              />
            </View>

            {/* 5. Tilawah Al-Qur'an */}
            <View style={[styles.checkCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <View style={styles.checkCardHeader}>
                <Text style={styles.itemIcon}>📖</Text>
                <View style={styles.itemTextContainer}>
                  <Text style={[styles.itemTitle, { color: colors.text }]}>Tilawah Al-Qur'an (One Day One Juz)</Text>
                  <Text style={[styles.itemSubtitle, { color: colors.textLight }]}>Jumlah halaman / lembar yang dibaca hari ini</Text>
                </View>
              </View>
              <View style={styles.tilawahInputRow}>
                <TextInput
                  style={[
                    styles.tilawahInput,
                    { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text },
                  ]}
                  value={tilawahPages}
                  onChangeText={setTilawahPages}
                  keyboardType="numeric"
                  placeholder="4"
                />
                <Text style={[styles.tilawahUnitText, { color: colors.text }]}>Lembar / Halaman</Text>
              </View>
            </View>

            {/* 6. Dzikir Pagi & Petang (Al-Ma'tsurat) */}
            <View style={[styles.checkCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <View style={styles.checkCardHeader}>
                <Text style={styles.itemIcon}>📜</Text>
                <View style={styles.itemTextContainer}>
                  <Text style={[styles.itemTitle, { color: colors.text }]}>Dzikir Al-Ma'tsurat</Text>
                  <Text style={[styles.itemSubtitle, { color: colors.textLight }]}>Dzikir pagi dan petang hari</Text>
                </View>
              </View>
              <View style={styles.matsuratBtnRow}>
                {[
                  { key: 'lengkap', label: 'Pagi & Petang' },
                  { key: 'pagi', label: 'Pagi Saja' },
                  { key: 'petang', label: 'Petang Saja' },
                  { key: 'none', label: 'Tidak Sempat' },
                ].map((item) => (
                  <TouchableOpacity
                    key={item.key}
                    style={[
                      styles.matsuratBtn,
                      {
                        backgroundColor: matsurat === item.key ? colors.primary : colors.surfaceSub,
                        borderColor: colors.border,
                      },
                    ]}
                    onPress={() => setMatsurat(item.key)}
                  >
                    <Text style={[styles.matsuratBtnText, { color: matsurat === item.key ? '#fff' : colors.text }]}>
                      {item.label}
                    </Text>
                  </TouchableOpacity>
                ))}
              </View>
            </View>

            {/* 7. Puasa Sunnah, Infaq & Baca Buku */}
            <View style={[styles.toggleCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <View style={styles.toggleLeft}>
                <Text style={styles.itemIcon}>🍞</Text>
                <View>
                  <Text style={[styles.itemTitle, { color: colors.text }]}>Shaum / Puasa Sunnah</Text>
                  <Text style={[styles.itemSubtitle, { color: colors.textLight }]}>Senin-Kamis / Ayyamul Bidh</Text>
                </View>
              </View>
              <Switch
                value={puasa}
                onValueChange={setPuasa}
                trackColor={{ false: '#cbd5e1', true: colors.primary }}
                thumbColor="#ffffff"
              />
            </View>

            <View style={[styles.toggleCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <View style={styles.toggleLeft}>
                <Text style={styles.itemIcon}>💰</Text>
                <View>
                  <Text style={[styles.itemTitle, { color: colors.text }]}>Infaq / Shadaqah Harian</Text>
                  <Text style={[styles.itemSubtitle, { color: colors.textLight }]}>Kotak infaq / transfer sosial</Text>
                </View>
              </View>
              <Switch
                value={infaq}
                onValueChange={setInfaq}
                trackColor={{ false: '#cbd5e1', true: colors.primary }}
                thumbColor="#ffffff"
              />
            </View>

            <View style={[styles.toggleCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <View style={styles.toggleLeft}>
                <Text style={styles.itemIcon}>📚</Text>
                <View>
                  <Text style={[styles.itemTitle, { color: colors.text }]}>Membaca Buku Islami / Hadits</Text>
                  <Text style={[styles.itemSubtitle, { color: colors.textLight }]}>Minimal 15 menit per hari</Text>
                </View>
              </View>
              <Switch
                value={bacaBuku}
                onValueChange={setBacaBuku}
                trackColor={{ false: '#cbd5e1', true: colors.primary }}
                thumbColor="#ffffff"
              />
            </View>

            {/* Notes */}
            <View style={[styles.checkCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <Text style={[styles.itemTitle, { color: colors.text, marginBottom: 6 }]}>
                ✍️ Catatan Ibadah &amp; Doa Harian
              </Text>
              <TextInput
                style={[
                  styles.notesInput,
                  { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text },
                ]}
                multiline
                numberOfLines={3}
                placeholder="Catatan perkembangan ibadah atau kendala hari ini..."
                placeholderTextColor="#94a3b8"
                value={notes}
                onChangeText={setNotes}
              />
            </View>

            {/* Save Button */}
            <TouchableOpacity
              style={[styles.saveBtn, { backgroundColor: colors.primary }]}
              onPress={handleSave}
              disabled={submitting}
              activeOpacity={0.8}
            >
              {submitting ? (
                <ActivityIndicator color="#fff" />
              ) : (
                <Text style={styles.saveBtnText}>💾 Simpan &amp; Kirim Laporan ke Pembina BPI ➔</Text>
              )}
            </TouchableOpacity>
          </>
        ) : (
          /* Tab Riwayat */
          <View>
            <Text style={[styles.sectionTitle, { color: colors.text }]}>Rekapitulasi Ibadah Bulanan</Text>
            {historyList.length === 0 ? (
              <View style={[styles.emptyBox, { backgroundColor: colors.surface, borderColor: colors.border }]}>
                <Text style={styles.emptyIcon}>🕌</Text>
                <Text style={[styles.emptyText, { color: colors.text }]}>Belum ada riwayat mutabaah.</Text>
                <Text style={[styles.emptySub, { color: colors.textLight }]}>
                  Isi checklist ibadah setiap hari untuk melihat rekap.
                </Text>
              </View>
            ) : (
              historyList.map((item, idx) => (
                <View
                  key={idx}
                  style={[styles.historyCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
                >
                  <View style={styles.historyTop}>
                    <Text style={[styles.historyDate, { color: colors.text }]}>
                      📅 {formatDateIndonesia(item.date)}
                    </Text>
                    <View style={[styles.verifiedBadge, { backgroundColor: item.verified_by_mentor ? '#dcfce7' : '#fef3c7' }]}>
                      <Text style={[styles.verifiedBadgeText, { color: item.verified_by_mentor ? '#15803d' : '#b45309' }]}>
                        {item.verified_by_mentor ? '✓ Terverifikasi Pembina' : 'Belum Diverifikasi'}
                      </Text>
                    </View>
                  </View>

                  <View style={styles.historyMetricsGrid}>
                    <Text style={[styles.metricSnippet, { color: colors.text }]}>
                      🕌 Sholat Jamaah: <Text style={{ fontWeight: '800' }}>{item.sholat_fardhu_jamaah} Waktu</Text>
                    </Text>
                    <Text style={[styles.metricSnippet, { color: colors.text }]}>
                      🌙 Tahajjud: <Text style={{ fontWeight: '800' }}>{item.sholat_tahajjud ? 'Ya' : 'Tidak'}</Text>
                    </Text>
                    <Text style={[styles.metricSnippet, { color: colors.text }]}>
                      📖 Tilawah: <Text style={{ fontWeight: '800' }}>{item.tilawah_pages} Lembar</Text>
                    </Text>
                    <Text style={[styles.metricSnippet, { color: colors.text }]}>
                      📜 Ma'tsurat: <Text style={{ fontWeight: '800' }}>{item.al_matsurat}</Text>
                    </Text>
                  </View>

                  {item.notes ? (
                    <Text style={[styles.historyNote, { color: colors.textLight }]}>
                      "{item.notes}"
                    </Text>
                  ) : null}
                </View>
              ))
            )}
          </View>
        )}

      </ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  tabBar: {
    flexDirection: 'row',
    borderBottomWidth: 1,
  },
  tabBtn: {
    flex: 1,
    paddingVertical: 14,
    alignItems: 'center',
  },
  tabText: {
    fontSize: 12,
    fontWeight: '800',
  },
  scrollContent: {
    padding: 16,
    paddingBottom: 40,
  },
  scoreHero: {
    borderRadius: 22,
    padding: 18,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 16,
    shadowColor: '#000',
    shadowOpacity: 0.12,
    shadowRadius: 8,
    elevation: 3,
  },
  scoreLeft: {
    flex: 1,
  },
  scoreBadge: {
    color: '#c6f634',
    fontSize: 9,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  scoreValue: {
    color: '#ffffff',
    fontSize: 36,
    fontWeight: '900',
    marginVertical: 2,
  },
  scoreDesc: {
    color: 'rgba(255,255,255,0.9)',
    fontSize: 11,
    fontWeight: '700',
  },
  scoreRightCircle: {
    width: 60,
    height: 60,
    borderRadius: 30,
    backgroundColor: 'rgba(255,255,255,0.2)',
    alignItems: 'center',
    justifyContent: 'center',
  },
  scoreIcon: {
    fontSize: 28,
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 10,
  },
  checkCard: {
    padding: 16,
    borderRadius: 18,
    borderWidth: 1,
    marginBottom: 10,
  },
  checkCardHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 12,
  },
  itemIcon: {
    fontSize: 20,
    marginRight: 10,
  },
  itemTextContainer: {
    flex: 1,
  },
  itemTitle: {
    fontSize: 13,
    fontWeight: '800',
  },
  itemSubtitle: {
    fontSize: 11,
    marginTop: 2,
  },
  counterRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 6,
  },
  counterBtn: {
    paddingHorizontal: 10,
    paddingVertical: 8,
    borderRadius: 10,
    borderWidth: 1,
  },
  counterBtnText: {
    fontSize: 11,
    fontWeight: '800',
  },
  toggleCard: {
    padding: 14,
    borderRadius: 18,
    borderWidth: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  toggleLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    flex: 1,
  },
  tilawahInputRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
  },
  tilawahInput: {
    width: 70,
    paddingVertical: 8,
    paddingHorizontal: 12,
    borderRadius: 12,
    borderWidth: 1,
    fontSize: 16,
    fontWeight: '900',
    textAlign: 'center',
  },
  tilawahUnitText: {
    fontSize: 13,
    fontWeight: '700',
  },
  matsuratBtnRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 6,
  },
  matsuratBtn: {
    paddingHorizontal: 10,
    paddingVertical: 7,
    borderRadius: 10,
    borderWidth: 1,
  },
  matsuratBtnText: {
    fontSize: 11,
    fontWeight: '800',
  },
  notesInput: {
    padding: 12,
    borderRadius: 12,
    borderWidth: 1,
    fontSize: 12,
    height: 70,
    textAlignVertical: 'top',
  },
  saveBtn: {
    paddingVertical: 15,
    borderRadius: 18,
    alignItems: 'center',
    marginTop: 10,
    marginBottom: 20,
    shadowColor: '#000',
    shadowOpacity: 0.12,
    shadowRadius: 8,
    elevation: 3,
  },
  saveBtnText: {
    color: '#ffffff',
    fontSize: 13,
    fontWeight: '900',
  },
  emptyBox: {
    padding: 30,
    borderRadius: 20,
    borderWidth: 1,
    alignItems: 'center',
  },
  emptyIcon: {
    fontSize: 36,
    marginBottom: 8,
  },
  emptyText: {
    fontSize: 14,
    fontWeight: '800',
  },
  emptySub: {
    fontSize: 12,
    marginTop: 4,
    textAlign: 'center',
  },
  historyCard: {
    padding: 16,
    borderRadius: 18,
    borderWidth: 1,
    marginBottom: 10,
  },
  historyTop: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 10,
  },
  historyDate: {
    fontSize: 13,
    fontWeight: '800',
  },
  verifiedBadge: {
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 6,
  },
  verifiedBadgeText: {
    fontSize: 9,
    fontWeight: '800',
    textTransform: 'uppercase',
  },
  historyMetricsGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 8,
  },
  metricSnippet: {
    fontSize: 11,
    width: '48%',
  },
  historyNote: {
    fontSize: 11,
    fontStyle: 'italic',
    marginTop: 8,
    paddingTop: 8,
    borderTopWidth: 0.5,
    borderTopColor: 'rgba(0,0,0,0.05)',
  },
});
