import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  TextInput,
  Image,
  Alert,
  Modal,
  ActivityIndicator,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import StatusBadge from '../components/StatusBadge';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';
import { formatDateIndonesia } from '../utils/formatters';

export default function BpiScreen({ navigation }) {
  const { colors } = useTheme();

  const [activeTab, setActiveTab] = useState('group'); // 'group' | 'meetings' | 'mentor'
  const [bpiData, setBpiData] = useState(null);
  const [mentorData, setMentorData] = useState(null);
  const [loading, setLoading] = useState(true);

  // Modal Pertemuan Baru
  const [meetingModalVisible, setMeetingModalVisible] = useState(false);
  const [topicTitle, setTopicTitle] = useState('');
  const [meetingDate, setMeetingDate] = useState('2026-08-22');
  const [summaryNotes, setSummaryNotes] = useState('');
  const [savingMeeting, setSavingMeeting] = useState(false);

  const fetchBpiGroup = async () => {
    try {
      const res = await hrisApi.getBpiGroup();
      if (res.status === 'success') {
        setBpiData(res.data);
      }
    } catch (e) {
      console.error('Error fetching BPI group', e);
    }
  };

  const fetchMentorView = async () => {
    try {
      const res = await hrisApi.getMentorDashboard();
      if (res.status === 'success') {
        setMentorData(res.data);
      }
    } catch (e) {
      console.error('Error fetching mentor view', e);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchBpiGroup();
    fetchMentorView();
  }, []);

  const handleSaveMeeting = async () => {
    if (!topicTitle.trim()) {
      Alert.alert('Form Belum Lengkap', 'Harap isi Judul Materi / Taujih Pertemuan.');
      return;
    }

    setSavingMeeting(true);
    try {
      const res = await hrisApi.saveBpiMeeting({
        group_id: bpiData?.group?.id || 1,
        topic_title: topicTitle.trim(),
        date: meetingDate,
        summary_notes: summaryNotes.trim(),
      });

      if (res.status === 'success') {
        Alert.alert('Berhasil', res.message);
        setMeetingModalVisible(false);
        setTopicTitle('');
        setSummaryNotes('');
        fetchBpiGroup();
      }
    } catch (e) {
      Alert.alert('Error', 'Gagal mencatat pertemuan.');
    } finally {
      setSavingMeeting(false);
    }
  };

  const group = bpiData?.group;
  const mentor = bpiData?.mentor;
  const members = bpiData?.members || [];
  const meetings = bpiData?.meetings || [];

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Bina Pribadi Islami (BPI)" subtitle="Halaqah Tarbiyah SDM SIT Robbani" />

      {/* Tabs */}
      <View style={[styles.tabBar, { backgroundColor: colors.surface, borderBottomColor: colors.border }]}>
        <TouchableOpacity
          style={[styles.tabBtn, activeTab === 'group' && { borderBottomColor: colors.primary, borderBottomWidth: 3 }]}
          onPress={() => setActiveTab('group')}
        >
          <Text style={[styles.tabText, { color: activeTab === 'group' ? colors.primary : colors.textLight }]}>
            👥 Kelompok Saya
          </Text>
        </TouchableOpacity>

        <TouchableOpacity
          style={[styles.tabBtn, activeTab === 'meetings' && { borderBottomColor: colors.primary, borderBottomWidth: 3 }]}
          onPress={() => setActiveTab('meetings')}
        >
          <Text style={[styles.tabText, { color: activeTab === 'meetings' ? colors.primary : colors.textLight }]}>
            📖 Pertemuan
          </Text>
        </TouchableOpacity>

        <TouchableOpacity
          style={[styles.tabBtn, activeTab === 'mentor' && { borderBottomColor: colors.primary, borderBottomWidth: 3 }]}
          onPress={() => setActiveTab('mentor')}
        >
          <Text style={[styles.tabText, { color: activeTab === 'mentor' ? colors.primary : colors.textLight }]}>
            👑 Pantau Binaan
          </Text>
        </TouchableOpacity>
      </View>

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {activeTab === 'group' && (
          <>
            {/* Group Banner */}
            <View style={[styles.groupBanner, { backgroundColor: colors.primary }]}>
              <Text style={styles.groupBadge}>HALAQAH BPI SDM ROBBANI</Text>
              <Text style={styles.groupName}>{group?.name || 'Halaqah BPI SDM 1 - Utsman Bin Affan'}</Text>
              <View style={styles.groupScheduleRow}>
                <Text style={styles.groupScheduleText}>
                  🗓️ Setiap {group?.schedule_day || 'Jumat'}, {group?.schedule_time || '16:00 WIB'}
                </Text>
                <Text style={styles.groupScheduleText}>
                  📍 {group?.location || 'Masjid Utama Kampus'}
                </Text>
              </View>
            </View>

            {/* Mentor Profile Card */}
            <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}>
              <Text style={[styles.sectionTitle, { color: colors.text, marginBottom: 10 }]}>
                Pembina (Murabbi) Halaqah
              </Text>
              <View style={styles.mentorRow}>
                <Image
                  source={{ uri: mentor?.avatar || 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200' }}
                  style={[styles.mentorAvatar, { borderColor: colors.primary }]}
                />
                <View style={styles.mentorInfo}>
                  <Text style={[styles.mentorName, { color: colors.text }]}>{mentor?.name}</Text>
                  <Text style={[styles.mentorTitle, { color: colors.primary }]}>{mentor?.title}</Text>
                  <Text style={[styles.mentorSub, { color: colors.textLight }]}>
                    Pengampu Materi Tarbiyah &amp; Evaluator Yaumiyah
                  </Text>
                </View>
              </View>
            </View>

            {/* Members List */}
            <Text style={[styles.sectionTitle, { color: colors.text, marginTop: 8 }]}>
              Daftar Anggota Halaqah ({members.length} SDM)
            </Text>

            {members.map((m, idx) => (
              <View
                key={idx}
                style={[styles.memberCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
              >
                <View style={styles.memberLeft}>
                  <View style={[styles.memberNumCircle, { backgroundColor: colors.surfaceSub }]}>
                    <Text style={[styles.memberNumText, { color: colors.primary }]}>{idx + 1}</Text>
                  </View>
                  <View>
                    <Text style={[styles.memberName, { color: colors.text }]}>{m.full_name}</Text>
                    <Text style={[styles.memberPos, { color: colors.textLight }]}>
                      {m.position} • NIP: {m.nip || '-'}
                    </Text>
                  </View>
                </View>
                <View style={[styles.statusPill, { backgroundColor: '#dcfce7' }]}>
                  <Text style={[styles.statusPillText, { color: '#15803d' }]}>AKTIF</Text>
                </View>
              </View>
            ))}
          </>
        )}

        {activeTab === 'meetings' && (
          <>
            <View style={styles.meetingHeaderRow}>
              <Text style={[styles.sectionTitle, { color: colors.text }]}>Jadwal &amp; Materi Pertemuan BPI</Text>
              <TouchableOpacity
                style={[styles.addMeetingBtn, { backgroundColor: colors.primary }]}
                onPress={() => setMeetingModalVisible(true)}
              >
                <Text style={styles.addMeetingBtnText}>+ Catat Pertemuan</Text>
              </TouchableOpacity>
            </View>

            {meetings.map((item, idx) => (
              <View
                key={idx}
                style={[styles.meetingCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
              >
                <View style={styles.meetingTop}>
                  <Text style={[styles.meetingDate, { color: colors.primary }]}>
                    📅 {formatDateIndonesia(item.date)}
                  </Text>
                  <Text style={[styles.meetingBadge, { backgroundColor: colors.surfaceSub, color: colors.text }]}>
                    PERTEMUAN KE-{meetings.length - idx}
                  </Text>
                </View>

                <Text style={[styles.meetingTopic, { color: colors.text }]}>{item.topic_title}</Text>
                <Text style={[styles.meetingSummary, { color: colors.textLight }]}>{item.summary_notes}</Text>
              </View>
            ))}
          </>
        )}

        {activeTab === 'mentor' && (
          <>
            {/* Mentor Oversight Hero */}
            <View style={[styles.mentorHero, { backgroundColor: colors.secondary }]}>
              <Text style={styles.mentorHeroBadge}>DASHBOARD PEMBINA (MURABBI SDM)</Text>
              <Text style={styles.mentorHeroTitle}>{mentorData?.group_name || 'Halaqah BPI SDM 1'}</Text>
              <Text style={styles.mentorHeroSub}>
                Total Binaan: {mentorData?.total_mentees || 6} Orang • Sudah Lapor Hari Ini: {mentorData?.completed_today || 4} Orang
              </Text>
            </View>

            <Text style={[styles.sectionTitle, { color: colors.text }]}>
              Pantauan Amal Ibadah Seluruh Binaan Hari Ini
            </Text>

            {mentorData?.mentees?.map((mentee, idx) => (
              <View
                key={idx}
                style={[styles.menteeCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
              >
                <View style={styles.menteeHeader}>
                  <View>
                    <Text style={[styles.menteeName, { color: colors.text }]}>{mentee.full_name}</Text>
                    <Text style={[styles.menteePos, { color: colors.textLight }]}>{mentee.position}</Text>
                  </View>
                  <View
                    style={[
                      styles.laporBadge,
                      { backgroundColor: mentee.mutabaah_date ? '#dcfce7' : '#fee2e2' },
                    ]}
                  >
                    <Text
                      style={[
                        styles.laporBadgeText,
                        { color: mentee.mutabaah_date ? '#15803d' : '#b91c1c' },
                      ]}
                    >
                      {mentee.mutabaah_date ? '✓ SUDAH MENGISI' : 'BELUM MENGISI'}
                    </Text>
                  </View>
                </View>

                {mentee.mutabaah_date ? (
                  <View style={styles.menteeMetricsRow}>
                    <View style={styles.menteeMetricItem}>
                      <Text style={styles.metricItemIcon}>🕌</Text>
                      <Text style={[styles.metricItemText, { color: colors.text }]}>
                        {mentee.sholat_fardhu_jamaah || 5} Wkt
                      </Text>
                    </View>
                    <View style={styles.menteeMetricItem}>
                      <Text style={styles.metricItemIcon}>🌙</Text>
                      <Text style={[styles.metricItemText, { color: colors.text }]}>
                        {mentee.sholat_tahajjud ? 'Tahajjud' : 'Tidak'}
                      </Text>
                    </View>
                    <View style={styles.menteeMetricItem}>
                      <Text style={styles.metricItemIcon}>📖</Text>
                      <Text style={[styles.metricItemText, { color: colors.text }]}>
                        {mentee.tilawah_pages || 4} Lembar
                      </Text>
                    </View>
                    <View style={styles.menteeMetricItem}>
                      <Text style={styles.metricItemIcon}>📜</Text>
                      <Text style={[styles.metricItemText, { color: colors.text }]}>
                        {mentee.al_matsurat || 'Lengkap'}
                      </Text>
                    </View>
                  </View>
                ) : (
                  <Text style={[styles.notYetText, { color: colors.textLight }]}>
                    Belum mengirim laporan amal ibadah hari ini.
                  </Text>
                )}

                <TouchableOpacity
                  style={[styles.giveNasihatBtn, { backgroundColor: colors.primary }]}
                  onPress={() => {
                    Alert.alert(
                      'Beri Nasihat / Taujih',
                      `Kirimkan catatan evaluasi dan motivasi istiqomah kepada ${mentee.full_name}?`,
                      [
                        { text: 'Batal', style: 'cancel' },
                        {
                          text: 'Kirim Nasihat WhatsApp',
                          onPress: () => Alert.alert('Terkirim', 'Pesan motivasi berhasil dikirim via WhatsApp.'),
                        },
                      ]
                    );
                  }}
                >
                  <Text style={styles.giveNasihatBtnText}>💬 Beri Catatan / Motivasi Pembina</Text>
                </TouchableOpacity>
              </View>
            ))}
          </>
        )}

      </ScrollView>

      {/* Modal Catat Pertemuan Baru */}
      <Modal visible={meetingModalVisible} animationType="slide" transparent onRequestClose={() => setMeetingModalVisible(false)}>
        <View style={styles.modalOverlay}>
          <View style={[styles.modalContent, { backgroundColor: colors.surface }]}>
            
            <View style={styles.modalHeader}>
              <Text style={[styles.modalTitle, { color: colors.text }]}>📖 Catat Pertemuan Mingguan BPI</Text>
              <TouchableOpacity onPress={() => setMeetingModalVisible(false)} style={styles.closeBtn}>
                <Text style={styles.closeBtnText}>✕</Text>
              </TouchableOpacity>
            </View>

            <Text style={[styles.inputLabel, { color: colors.text }]}>Tanggal Pertemuan (YYYY-MM-DD)</Text>
            <TextInput
              style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
              value={meetingDate}
              onChangeText={setMeetingDate}
            />

            <Text style={[styles.inputLabel, { color: colors.text }]}>Judul Materi / Taujih Pembina</Text>
            <TextInput
              style={[styles.input, { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text }]}
              placeholder="contoh: Tazkiyatun Nafs & Keikhlasan Mengajar"
              placeholderTextColor="#94a3b8"
              value={topicTitle}
              onChangeText={setTopicTitle}
            />

            <Text style={[styles.inputLabel, { color: colors.text }]}>Ringkasan Pembahasan &amp; Tugas Halaqah</Text>
            <TextInput
              style={[
                styles.input,
                styles.textArea,
                { backgroundColor: colors.surfaceSub, borderColor: colors.border, color: colors.text },
              ]}
              multiline
              numberOfLines={3}
              placeholder="Catatan penting yang disampaikan oleh pembina..."
              placeholderTextColor="#94a3b8"
              value={summaryNotes}
              onChangeText={setSummaryNotes}
            />

            <TouchableOpacity
              style={[styles.submitMeetingBtn, { backgroundColor: colors.primary }]}
              onPress={handleSaveMeeting}
              disabled={savingMeeting}
            >
              {savingMeeting ? (
                <ActivityIndicator color="#fff" />
              ) : (
                <Text style={styles.submitMeetingBtnText}>Simpan Catatan Pertemuan ➔</Text>
              )}
            </TouchableOpacity>

          </View>
        </View>
      </Modal>

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
    fontSize: 11,
    fontWeight: '800',
  },
  scrollContent: {
    padding: 16,
    paddingBottom: 40,
  },
  groupBanner: {
    borderRadius: 22,
    padding: 18,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 3,
  },
  groupBadge: {
    color: '#c6f634',
    fontSize: 9,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  groupName: {
    color: '#ffffff',
    fontSize: 16,
    fontWeight: '900',
    marginVertical: 4,
  },
  groupScheduleRow: {
    marginTop: 6,
    gap: 2,
  },
  groupScheduleText: {
    color: 'rgba(255,255,255,0.9)',
    fontSize: 11,
    fontWeight: '600',
  },
  card: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    marginBottom: 12,
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 8,
  },
  mentorRow: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  mentorAvatar: {
    width: 54,
    height: 54,
    borderRadius: 27,
    borderWidth: 2,
    marginRight: 12,
  },
  mentorInfo: {
    flex: 1,
  },
  mentorName: {
    fontSize: 14,
    fontWeight: '900',
  },
  mentorTitle: {
    fontSize: 11,
    fontWeight: '800',
    marginTop: 2,
  },
  mentorSub: {
    fontSize: 10,
    marginTop: 2,
  },
  memberCard: {
    padding: 12,
    borderRadius: 16,
    borderWidth: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  memberLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    flex: 1,
  },
  memberNumCircle: {
    width: 28,
    height: 28,
    borderRadius: 14,
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 10,
  },
  memberNumText: {
    fontSize: 12,
    fontWeight: '900',
  },
  memberName: {
    fontSize: 12,
    fontWeight: '800',
  },
  memberPos: {
    fontSize: 10,
    marginTop: 2,
  },
  statusPill: {
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 6,
  },
  statusPillText: {
    fontSize: 9,
    fontWeight: '900',
  },
  meetingHeaderRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 10,
  },
  addMeetingBtn: {
    paddingHorizontal: 12,
    paddingVertical: 7,
    borderRadius: 10,
  },
  addMeetingBtnText: {
    color: '#ffffff',
    fontSize: 11,
    fontWeight: '800',
  },
  meetingCard: {
    padding: 16,
    borderRadius: 18,
    borderWidth: 1,
    marginBottom: 10,
  },
  meetingTop: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 6,
  },
  meetingDate: {
    fontSize: 11,
    fontWeight: '800',
  },
  meetingBadge: {
    fontSize: 9,
    fontWeight: '900',
    paddingHorizontal: 6,
    paddingVertical: 2,
    borderRadius: 4,
  },
  meetingTopic: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 4,
  },
  meetingSummary: {
    fontSize: 11,
    lineHeight: 16,
  },
  mentorHero: {
    borderRadius: 20,
    padding: 18,
    marginBottom: 14,
  },
  mentorHeroBadge: {
    color: '#ffffff',
    fontSize: 9,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  mentorHeroTitle: {
    color: '#ffffff',
    fontSize: 18,
    fontWeight: '900',
    marginVertical: 2,
  },
  mentorHeroSub: {
    color: 'rgba(255,255,255,0.9)',
    fontSize: 11,
    fontWeight: '600',
  },
  menteeCard: {
    padding: 16,
    borderRadius: 18,
    borderWidth: 1,
    marginBottom: 12,
  },
  menteeHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  menteeName: {
    fontSize: 13,
    fontWeight: '800',
  },
  menteePos: {
    fontSize: 10,
    marginTop: 2,
  },
  laporBadge: {
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 6,
  },
  laporBadgeText: {
    fontSize: 9,
    fontWeight: '900',
  },
  menteeMetricsRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    backgroundColor: 'rgba(0,0,0,0.02)',
    padding: 10,
    borderRadius: 12,
    marginVertical: 8,
  },
  menteeMetricItem: {
    alignItems: 'center',
  },
  metricItemIcon: {
    fontSize: 14,
    marginBottom: 2,
  },
  metricItemText: {
    fontSize: 10,
    fontWeight: '700',
  },
  notYetText: {
    fontSize: 11,
    fontStyle: 'italic',
    marginVertical: 8,
  },
  giveNasihatBtn: {
    paddingVertical: 9,
    borderRadius: 12,
    alignItems: 'center',
    marginTop: 6,
  },
  giveNasihatBtnText: {
    color: '#ffffff',
    fontSize: 11,
    fontWeight: '800',
  },
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0,0,0,0.6)',
    justifyContent: 'flex-end',
  },
  modalContent: {
    borderTopLeftRadius: 28,
    borderTopRightRadius: 28,
    padding: 20,
    maxHeight: '90%',
  },
  modalHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 14,
  },
  modalTitle: {
    fontSize: 15,
    fontWeight: '800',
  },
  closeBtn: {
    width: 30,
    height: 30,
    borderRadius: 15,
    backgroundColor: 'rgba(0,0,0,0.06)',
    alignItems: 'center',
    justifyContent: 'center',
  },
  closeBtnText: {
    fontSize: 14,
    fontWeight: 'bold',
  },
  inputLabel: {
    fontSize: 11,
    fontWeight: '700',
    marginTop: 10,
    marginBottom: 4,
  },
  input: {
    paddingHorizontal: 12,
    paddingVertical: 10,
    borderRadius: 12,
    borderWidth: 1,
    fontSize: 12,
  },
  textArea: {
    height: 70,
    textAlignVertical: 'top',
  },
  submitMeetingBtn: {
    paddingVertical: 14,
    borderRadius: 16,
    alignItems: 'center',
    marginTop: 16,
  },
  submitMeetingBtnText: {
    color: '#ffffff',
    fontSize: 13,
    fontWeight: '900',
  },
});
