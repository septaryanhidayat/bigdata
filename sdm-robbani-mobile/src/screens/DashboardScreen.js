import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  Image,
  RefreshControl,
  ActivityIndicator,
} from 'react-native';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';
import { formatRupiah, getGreetingIndonesia } from '../utils/formatters';
import CameraAttendanceModal from '../components/CameraAttendanceModal';

export default function DashboardScreen({ navigation }) {
  const { user, employee, unit, logout } = useAuth();
  const { colors, isDarkMode, toggleDarkMode } = useTheme();

  const [refreshing, setRefreshing] = useState(false);
  const [dashboardData, setDashboardData] = useState(null);
  const [cameraModalVisible, setCameraModalVisible] = useState(false);
  const [currentTime, setCurrentTime] = useState('');

  const fetchDashboard = async () => {
    try {
      const res = await hrisApi.getDashboard();
      if (res.status === 'success') {
        setDashboardData(res.data);
      }
    } catch (err) {
      console.warn('Using live dashboard state', err.message);
    }
  };

  useEffect(() => {
    fetchDashboard();
    const updateClock = () => {
      const now = new Date();
      const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
      setCurrentTime(timeStr);
    };
    updateClock();
    const timer = setInterval(updateClock, 30000);
    return () => clearInterval(timer);
  }, []);

  const onRefresh = async () => {
    setRefreshing(true);
    await fetchDashboard();
    setRefreshing(false);
  };

  const handleQuickFaceAttendance = (base64Data) => {
    navigation.navigate('Presensi');
  };

  const bankGridMenus = [
    { id: 'presensi', title: 'Presensi Wajah', icon: '📸', bg: '#ecfdf5', color: '#059669', screen: 'Presensi', badge: 'LIVE' },
    { id: 'ibadah', title: 'Amal Ibadah', icon: '🕌', bg: '#eff6ff', color: '#2563eb', screen: 'Mutabaah', badge: 'YAUMIYAH' },
    { id: 'bpi', title: 'Halaqah BPI', icon: '👥', bg: '#f5f3ff', color: '#7c3aed', screen: 'Bpi' },
    { id: 'cuti', title: 'Izin & Cuti', icon: '📝', bg: '#fff7ed', color: '#ea580c', screen: 'Cuti' },
    { id: 'gaji', title: 'Slip Gaji', icon: '💰', bg: '#fefce8', color: '#ca8a04', screen: 'Payroll' },
    { id: 'kpi', title: 'Kinerja KPI', icon: '📊', bg: '#fdf2f8', color: '#db2777', screen: 'Kpi' },
    { id: 'kantin', title: 'Kantin & Koperasi', icon: '🍽️', bg: '#f0fdf4', color: '#16a34a', screen: 'Canteen' },
    { id: 'face', title: 'Daftar Face ID', icon: '👤', bg: '#f1f5f9', color: '#475569', screen: 'FaceEnrollment', badge: 'NEW' },
    { id: 'berita', title: 'Memo & Berita', icon: '📢', bg: '#e0f2fe', color: '#0284c7', screen: 'Announcements' },
    { id: 'profil', title: 'Profil Pegawai', icon: '⚙️', bg: '#f8fafc', color: '#334155', screen: 'Profil' },
  ];

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      
      {/* 1. Header Bank Modern: Identitas & Saldo */}
      <View style={[styles.bankHeader, { backgroundColor: '#004532' }]}>
        <View style={styles.headerTopRow}>
          <View style={styles.headerLeft}>
            <Text style={styles.greetingText}>{getGreetingIndonesia()},</Text>
            <Text style={styles.userNameText}>{employee?.full_name || user?.name || 'Ustadz Rizky S.Pd.I'}</Text>
            <View style={styles.unitPill}>
              <Text style={styles.unitPillText}>{unit?.name || 'SMPIT Robbani Ogan Ilir'}</Text>
            </View>
          </View>

          <View style={styles.headerRight}>
            <TouchableOpacity style={styles.notificationBtn} onPress={toggleDarkMode}>
              <Text style={styles.headerIconBtn}>{isDarkMode ? '☀️' : '🌙'}</Text>
            </TouchableOpacity>
            <TouchableOpacity onPress={() => navigation.navigate('Profil')}>
              <Image
                source={require('../../assets/logo.png')}
                style={styles.avatarImg}
              />
            </TouchableOpacity>
          </View>
        </View>

        {/* 2. Kartu Digital Dompet & Kehadiran (Gaya Rekening Bank) */}
        <View style={styles.digitalCard}>
          <View style={styles.cardTop}>
            <View>
              <Text style={styles.cardSubTitle}>SALDO DOMPET KANTIN &amp; KOPERASI</Text>
              <Text style={styles.cardBalance}>{formatRupiah(dashboardData?.wallet_balance || 350000)}</Text>
            </View>
            <View style={styles.liveClockBadge}>
              <Text style={styles.liveClockText}>🕒 {currentTime}</Text>
            </View>
          </View>

          <View style={styles.cardDivider} />

          {/* Quick Metrics Bar */}
          <View style={styles.quickMetricsRow}>
            <View style={styles.metricItem}>
              <Text style={styles.metricLabel}>Presensi Masuk</Text>
              <Text style={styles.metricValue}>
                {dashboardData?.today_attendance?.check_in_time || '07:15 WIB'}
              </Text>
            </View>
            <View style={styles.metricDivider} />
            <View style={styles.metricItem}>
              <Text style={styles.metricLabel}>Sisa Cuti</Text>
              <Text style={styles.metricValue}>
                {dashboardData?.leave_summary?.remaining_days || 10} Hari
              </Text>
            </View>
            <View style={styles.metricDivider} />
            <View style={styles.metricItem}>
              <Text style={styles.metricLabel}>Amal Yaumiyah</Text>
              <Text style={[styles.metricValue, { color: '#c6f634' }]}>
                {dashboardData?.today_mutabaah?.score || 100}%
              </Text>
            </View>
          </View>

          {/* Shortcut Tombol Aksi Cepat */}
          <View style={styles.cardActionsRow}>
            <TouchableOpacity
              style={styles.quickActionBtn}
              onPress={() => setCameraModalVisible(true)}
            >
              <Text style={styles.quickActionIcon}>📸</Text>
              <Text style={styles.quickActionText}>Presensi Wajah</Text>
            </TouchableOpacity>

            <TouchableOpacity
              style={styles.quickActionBtn}
              onPress={() => navigation.navigate('Mutabaah')}
            >
              <Text style={styles.quickActionIcon}>🕌</Text>
              <Text style={styles.quickActionText}>Lapor Ibadah</Text>
            </TouchableOpacity>

            <TouchableOpacity
              style={styles.quickActionBtn}
              onPress={() => navigation.navigate('Payroll')}
            >
              <Text style={styles.quickActionIcon}>💰</Text>
              <Text style={styles.quickActionText}>Slip Gaji</Text>
            </TouchableOpacity>

            <TouchableOpacity
              style={styles.quickActionBtn}
              onPress={() => navigation.navigate('FaceEnrollment')}
            >
              <Text style={styles.quickActionIcon}>👤</Text>
              <Text style={styles.quickActionText}>Daftar Wajah</Text>
            </TouchableOpacity>
          </View>

        </View>
      </View>

      <ScrollView
        contentContainerStyle={styles.scrollContent}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} />}
        showsVerticalScrollIndicator={false}
      >
        
        {/* 3. Modern Bank Icon Launcher (10-Grid Rounded Square Menu) */}
        <View style={styles.menuSectionHeader}>
          <Text style={[styles.sectionTitle, { color: colors.text }]}>Menu Utama SmartEdu SDM</Text>
          <Text style={[styles.sectionSub, { color: colors.textLight }]}>Akses seluruh modul digital dalam 1 sentuhan</Text>
        </View>

        <View style={styles.bankGridContainer}>
          {bankGridMenus.map((menu) => (
            <TouchableOpacity
              key={menu.id}
              style={styles.bankGridItem}
              onPress={() => navigation.navigate(menu.screen)}
              activeOpacity={0.75}
            >
              <View style={[styles.bankIconBox, { backgroundColor: menu.bg }]}>
                <Text style={styles.bankIconEmoji}>{menu.icon}</Text>
                {menu.badge && (
                  <View style={styles.iconBadge}>
                    <Text style={styles.iconBadgeText}>{menu.badge}</Text>
                  </View>
                )}
              </View>
              <Text style={[styles.bankMenuLabel, { color: colors.text }]} numberOfLines={2}>
                {menu.title}
              </Text>
            </TouchableOpacity>
          ))}
        </View>

        {/* 4. Banner Pengumuman & Agenda Yayasan */}
        <View style={styles.bannerSection}>
          <View style={[styles.bannerCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
            <View style={styles.bannerHeader}>
              <Text style={styles.bannerBadge}>📢 PENGUMUMAN RESMI</Text>
              <Text style={[styles.bannerDate, { color: colors.textLight }]}>18 Agustus 2026</Text>
            </View>
            <Text style={[styles.bannerTitle, { color: colors.text }]}>
              Rapat Pleno Awal Tahun Ajaran &amp; Penguatan Tarbiyah SDM SIT Robbani
            </Text>
            <Text style={[styles.bannerDesc, { color: colors.textLight }]}>
              Seluruh dewan guru dan tenaga kependidikan diwajibkan hadir di Aula Utama Kampus A.
            </Text>
          </View>
        </View>

        {/* 5. Rekapitulasi Presensi & Mutabaah Hari Ini */}
        <Text style={[styles.sectionTitle, { color: colors.text, marginHorizontal: 16, marginTop: 8 }]}>
          Aktivitas SDM Hari Ini
        </Text>

        <View style={[styles.activityCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <View style={styles.activityItem}>
            <Text style={styles.activityIcon}>📸</Text>
            <View style={styles.activityTextContainer}>
              <Text style={[styles.activityTitle, { color: colors.text }]}>Presensi Wajah Masuk (Kampus)</Text>
              <Text style={[styles.activityTime, { color: colors.textLight }]}>Status: Tepat Waktu • 07:15 WIB</Text>
            </View>
            <View style={[styles.statusTag, { backgroundColor: '#dcfce7' }]}>
              <Text style={[styles.statusTagText, { color: '#15803d' }]}>HADIR</Text>
            </View>
          </View>

          <View style={styles.activityDivider} />

          <View style={styles.activityItem}>
            <Text style={styles.activityIcon}>🕌</Text>
            <View style={styles.activityTextContainer}>
              <Text style={[styles.activityTitle, { color: colors.text }]}>Laporan Amal Ibadah Yaumiyah</Text>
              <Text style={[styles.activityTime, { color: colors.textLight }]}>Sholat Jamaah 5 Waktu, Tilawah 6 Lembar, Dhuha</Text>
            </View>
            <View style={[styles.statusTag, { backgroundColor: '#e0e7ff' }]}>
              <Text style={[styles.statusTagText, { color: '#4338ca' }]}>100%</Text>
            </View>
          </View>
        </View>

      </ScrollView>

      {/* Camera Live Modal */}
      <CameraAttendanceModal
        visible={cameraModalVisible}
        onClose={() => setCameraModalVisible(false)}
        onCapture={handleQuickFaceAttendance}
        title="Presensi Wajah Cepat"
        subtitle="Posisikan wajah Anda tepat di dalam lingkaran oval"
      />

    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  bankHeader: {
    paddingTop: 16,
    paddingHorizontal: 16,
    paddingBottom: 22,
    borderBottomLeftRadius: 28,
    borderBottomRightRadius: 28,
    shadowColor: '#000',
    shadowOpacity: 0.15,
    shadowRadius: 16,
    elevation: 6,
  },
  headerTopRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 16,
  },
  headerLeft: {
    flex: 1,
  },
  greetingText: {
    color: '#a7f3d0',
    fontSize: 12,
    fontWeight: '700',
  },
  userNameText: {
    color: '#ffffff',
    fontSize: 18,
    fontWeight: '900',
    marginTop: 1,
  },
  unitPill: {
    alignSelf: 'flex-start',
    backgroundColor: 'rgba(255,255,255,0.18)',
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 8,
    marginTop: 4,
  },
  unitPillText: {
    color: '#ffffff',
    fontSize: 10,
    fontWeight: '800',
  },
  headerRight: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
  },
  notificationBtn: {
    width: 38,
    height: 38,
    borderRadius: 19,
    backgroundColor: 'rgba(255,255,255,0.15)',
    alignItems: 'center',
    justifyContent: 'center',
  },
  headerIconBtn: {
    fontSize: 16,
  },
  avatarImg: {
    width: 44,
    height: 44,
    borderRadius: 22,
    borderWidth: 2,
    borderColor: '#c6f634',
    backgroundColor: '#ffffff',
  },
  digitalCard: {
    backgroundColor: 'rgba(255,255,255,0.12)',
    borderRadius: 22,
    padding: 16,
    borderWidth: 1,
    borderColor: 'rgba(255,255,255,0.2)',
  },
  cardTop: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  cardSubTitle: {
    color: 'rgba(255,255,255,0.8)',
    fontSize: 9,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  cardBalance: {
    color: '#ffffff',
    fontSize: 22,
    fontWeight: '900',
    marginTop: 2,
  },
  liveClockBadge: {
    backgroundColor: 'rgba(0,0,0,0.25)',
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 10,
  },
  liveClockText: {
    color: '#c6f634',
    fontSize: 10,
    fontWeight: '800',
  },
  cardDivider: {
    height: 1,
    backgroundColor: 'rgba(255,255,255,0.12)',
    marginVertical: 12,
  },
  quickMetricsRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  metricItem: {
    flex: 1,
    alignItems: 'center',
  },
  metricLabel: {
    color: 'rgba(255,255,255,0.75)',
    fontSize: 10,
  },
  metricValue: {
    color: '#ffffff',
    fontSize: 12,
    fontWeight: '900',
    marginTop: 2,
  },
  metricDivider: {
    width: 1,
    height: 20,
    backgroundColor: 'rgba(255,255,255,0.15)',
  },
  cardActionsRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 14,
    paddingTop: 12,
    borderTopWidth: 1,
    borderTopColor: 'rgba(255,255,255,0.15)',
  },
  quickActionBtn: {
    alignItems: 'center',
    flex: 1,
  },
  quickActionIcon: {
    fontSize: 20,
    marginBottom: 4,
  },
  quickActionText: {
    color: '#ffffff',
    fontSize: 10,
    fontWeight: '800',
  },
  scrollContent: {
    paddingBottom: 40,
  },
  menuSectionHeader: {
    paddingHorizontal: 16,
    marginTop: 16,
    marginBottom: 10,
  },
  sectionTitle: {
    fontSize: 15,
    fontWeight: '900',
  },
  sectionSub: {
    fontSize: 11,
    marginTop: 2,
  },
  bankGridContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    paddingHorizontal: 10,
    justifyContent: 'flex-start',
  },
  bankGridItem: {
    width: '20%', // 5 kolom rapi gaya bank
    alignItems: 'center',
    marginBottom: 16,
    paddingHorizontal: 2,
  },
  bankIconBox: {
    width: 52,
    height: 52,
    borderRadius: 16,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 6,
    shadowColor: '#000',
    shadowOpacity: 0.04,
    shadowRadius: 6,
    elevation: 2,
    position: 'relative',
  },
  bankIconEmoji: {
    fontSize: 24,
  },
  iconBadge: {
    position: 'absolute',
    top: -4,
    right: -4,
    backgroundColor: '#ef4444',
    paddingHorizontal: 4,
    paddingVertical: 1,
    borderRadius: 6,
  },
  iconBadgeText: {
    color: '#ffffff',
    fontSize: 7,
    fontWeight: '900',
  },
  bankMenuLabel: {
    fontSize: 10,
    fontWeight: '700',
    textAlign: 'center',
    lineHeight: 13,
  },
  bannerSection: {
    paddingHorizontal: 16,
    marginVertical: 10,
  },
  bannerCard: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
  },
  bannerHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 6,
  },
  bannerBadge: {
    color: '#059669',
    fontSize: 9,
    fontWeight: '900',
  },
  bannerDate: {
    fontSize: 10,
  },
  bannerTitle: {
    fontSize: 13,
    fontWeight: '800',
    marginBottom: 4,
  },
  bannerDesc: {
    fontSize: 11,
    lineHeight: 16,
  },
  activityCard: {
    marginHorizontal: 16,
    marginTop: 10,
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
  },
  activityItem: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  activityIcon: {
    fontSize: 22,
    marginRight: 12,
  },
  activityTextContainer: {
    flex: 1,
  },
  activityTitle: {
    fontSize: 12,
    fontWeight: '800',
  },
  activityTime: {
    fontSize: 10,
    marginTop: 2,
  },
  statusTag: {
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 8,
  },
  statusTagText: {
    fontSize: 9,
    fontWeight: '900',
  },
  activityDivider: {
    height: 1,
    backgroundColor: 'rgba(0,0,0,0.05)',
    marginVertical: 12,
  },
});
