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
  Platform,
  StatusBar,
} from 'react-native';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';
import { getGreetingIndonesia } from '../utils/formatters';
import CameraAttendanceModal from '../components/CameraAttendanceModal';

export default function DashboardScreen({ navigation }) {
  const { user, employee, unit, refreshProfile } = useAuth();
  const { colors, isDarkMode, toggleDarkMode } = useTheme();

  const [refreshing, setRefreshing] = useState(false);
  const [dashboardData, setDashboardData] = useState(null);
  const [cameraModalVisible, setCameraModalVisible] = useState(false);
  const [currentTime, setCurrentTime] = useState('');
  const [activePrayer, setActivePrayer] = useState({ name: 'Isya', time: '19:20' });

  const prayerTimes = [
    { id: 'subuh', name: 'Subuh', time: '04:48', icon: '🌅' },
    { id: 'dzuhur', name: 'Dzuhur', time: '12:08', icon: '☀️' },
    { id: 'ashar', name: 'Ashar', time: '15:28', icon: '⛅' },
    { id: 'maghrib', name: 'Maghrib', time: '18:09', icon: '🌇' },
    { id: 'isya', name: 'Isya', time: '19:20', icon: '🌙' },
  ];

  const fetchDashboard = async () => {
    try {
      refreshProfile?.();
      const res = await hrisApi.getDashboard();
      if (res?.status === 'success') {
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

      // Tentukan waktu sholat aktif
      const hour = now.getHours();
      const min = now.getMinutes();
      const totalMin = hour * 60 + min;

      if (totalMin < 4 * 60 + 48) setActivePrayer({ name: 'Subuh', time: '04:48' });
      else if (totalMin < 12 * 60 + 8) setActivePrayer({ name: 'Dzuhur', time: '12:08' });
      else if (totalMin < 15 * 60 + 28) setActivePrayer({ name: 'Ashar', time: '15:28' });
      else if (totalMin < 18 * 60 + 9) setActivePrayer({ name: 'Maghrib', time: '18:09' });
      else if (totalMin < 19 * 60 + 20) setActivePrayer({ name: 'Isya', time: '19:20' });
      else setActivePrayer({ name: 'Subuh', time: '04:48' });
    };
    updateClock();
    const timer = setInterval(updateClock, 30000);
    return () => clearInterval(timer);
  }, []);

  const onRefresh = async () => {
    setRefreshing(true);
    await Promise.all([fetchDashboard(), refreshProfile?.()]);
    setRefreshing(false);
  };

  const handleQuickFaceAttendance = () => {
    navigation.navigate('Presensi');
  };

  const bankGridMenus = [
    { id: 'presensi', title: 'Presensi Wajah', icon: '📸', bg: '#ecfdf5', screen: 'Presensi', badge: 'LIVE' },
    { id: 'ibadah', title: 'Amal Ibadah', icon: '🕌', bg: '#eff6ff', screen: 'Mutabaah', badge: 'YAUMIYAH' },
    { id: 'bpi', title: 'Halaqah BPI', icon: '👥', bg: '#f5f3ff', screen: 'Bpi' },
    { id: 'cuti', title: 'Izin & Cuti', icon: '📝', bg: '#fff7ed', screen: 'Cuti' },
    { id: 'gaji', title: 'Slip Gaji', icon: '💰', bg: '#fefce8', screen: 'Payroll' },
    { id: 'kpi', title: 'Kinerja KPI', icon: '📊', bg: '#fdf2f8', screen: 'Kpi' },
    { id: 'kantin', title: 'Kantin & Toko', icon: '🍽️', bg: '#f0fdf4', screen: 'Canteen' },
    { id: 'face', title: 'Daftar Face ID', icon: '👤', bg: '#f1f5f9', screen: 'FaceEnrollment', badge: 'NEW' },
    { id: 'quran', title: 'Al-Qur\'an 30 Juz', icon: '📖', bg: '#ecfeff', screen: 'Quran' },
    { id: 'matsurat', title: 'Al-Ma\'tsurat', icon: '📿', bg: '#fdf4ff', screen: 'Almatsurat' },
    { id: 'asmaul', title: 'Asmaul Husna', icon: '🕋', bg: '#fefce8', screen: 'AsmaulHusna' },
    { id: 'profil', title: 'Profil Pegawai', icon: '⚙️', bg: '#f8fafc', screen: 'Profil' },
  ];

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      
      {/* 1. Header Bank Modern: Identitas & Jadwal Sholat */}
      <View style={[styles.bankHeader, { backgroundColor: '#004532' }]}>
        <View style={styles.headerTopRow}>
          <View style={styles.headerLeft}>
            <Text style={styles.greetingText}>{getGreetingIndonesia()},</Text>
            <Text style={styles.userNameText}>{employee?.full_name || user?.name || 'Super Admin SmartEdu'}</Text>
            <View style={styles.unitPill}>
              <Text style={styles.unitPillText}>{unit?.name || 'Yayasan Generasi Robbani'}</Text>
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

        {/* 2. Kartu Jadwal Sholat & Waktu Ibadah (Pengganti Saldo) */}
        <View style={styles.digitalCard}>
          <View style={styles.cardTop}>
            <View>
              <Text style={styles.cardSubTitle}>🕌 JADWAL SHOLAT • KAB. OGAN ILIR</Text>
              <Text style={styles.activePrayerText}>
                Waktu Berikutnya: <Text style={{ color: '#c6f634' }}>{activePrayer.name} {activePrayer.time} WIB</Text>
              </Text>
            </View>
            <View style={styles.liveClockBadge}>
              <Text style={styles.liveClockText}>🕒 {currentTime}</Text>
            </View>
          </View>

          {/* 5 Waktu Sholat Horizontal Bar */}
          <View style={styles.prayerRow}>
            {prayerTimes.map((p) => {
              const isTarget = p.name === activePrayer.name;
              return (
                <View
                  key={p.id}
                  style={[
                    styles.prayerItem,
                    isTarget && { backgroundColor: 'rgba(198, 246, 52, 0.25)', borderColor: '#c6f634' },
                  ]}
                >
                  <Text style={styles.prayerIcon}>{p.icon}</Text>
                  <Text style={[styles.prayerName, isTarget && { color: '#c6f634', fontWeight: '900' }]}>
                    {p.name}
                  </Text>
                  <Text style={[styles.prayerTime, isTarget && { color: '#ffffff', fontWeight: '900' }]}>
                    {p.time}
                  </Text>
                </View>
              );
            })}
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
        
        {/* 3. Modern Bank Icon Launcher (4-Kolom Proporsional) */}
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
    paddingTop: Platform.OS === 'android' ? (StatusBar.currentHeight || 28) + 16 : 46,
    paddingHorizontal: 18,
    paddingBottom: 22,
    borderBottomLeftRadius: 32,
    borderBottomRightRadius: 32,
    shadowColor: '#000',
    shadowOpacity: 0.18,
    shadowRadius: 16,
    elevation: 6,
  },
  headerTopRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 14,
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
  activePrayerText: {
    color: '#ffffff',
    fontSize: 14,
    fontWeight: '800',
    marginTop: 3,
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
  prayerRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 12,
    gap: 4,
  },
  prayerItem: {
    flex: 1,
    alignItems: 'center',
    paddingVertical: 6,
    paddingHorizontal: 2,
    borderRadius: 12,
    backgroundColor: 'rgba(255,255,255,0.08)',
    borderWidth: 1,
    borderColor: 'rgba(255,255,255,0.12)',
  },
  prayerIcon: {
    fontSize: 13,
    marginBottom: 2,
  },
  prayerName: {
    color: 'rgba(255,255,255,0.8)',
    fontSize: 9,
    fontWeight: '700',
  },
  prayerTime: {
    color: '#ffffff',
    fontSize: 10,
    fontWeight: '800',
    marginTop: 2,
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
    paddingBottom: 110,
  },
  menuSectionHeader: {
    paddingHorizontal: 16,
    marginTop: 18,
    marginBottom: 12,
  },
  sectionTitle: {
    fontSize: 16,
    fontWeight: '900',
    letterSpacing: -0.2,
  },
  sectionSub: {
    fontSize: 11,
    marginTop: 2,
  },
  bankGridContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    paddingHorizontal: 12,
    justifyContent: 'flex-start',
  },
  bankGridItem: {
    width: '25%', // 4 kolom presisi & proporsional
    alignItems: 'center',
    marginBottom: 18,
    paddingHorizontal: 4,
  },
  bankIconBox: {
    width: 58,
    height: 58,
    borderRadius: 20,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 7,
    shadowColor: '#000',
    shadowOpacity: 0.06,
    shadowRadius: 8,
    elevation: 3,
    position: 'relative',
  },
  bankIconEmoji: {
    fontSize: 26,
  },
  iconBadge: {
    position: 'absolute',
    top: -5,
    right: -5,
    backgroundColor: '#ef4444',
    paddingHorizontal: 5,
    paddingVertical: 2,
    borderRadius: 8,
  },
  iconBadgeText: {
    color: '#ffffff',
    fontSize: 8,
    fontWeight: '900',
  },
  bankMenuLabel: {
    fontSize: 11,
    fontWeight: '800',
    textAlign: 'center',
    lineHeight: 14,
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
