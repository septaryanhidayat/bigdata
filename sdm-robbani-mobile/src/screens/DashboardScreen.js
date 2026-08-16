import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  RefreshControl,
  TouchableOpacity,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import QuickActionCard from '../components/QuickActionCard';
import GeofenceRadar from '../components/GeofenceRadar';
import StatusBadge from '../components/StatusBadge';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';
import { formatRupiah } from '../utils/formatters';

export default function DashboardScreen({ navigation }) {
  const { user, employee, unit } = useAuth();
  const { colors } = useTheme();

  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [dashboardData, setDashboardData] = useState(null);

  const fetchDashboard = async () => {
    try {
      const res = await hrisApi.getDashboard();
      if (res.status === 'success') {
        setDashboardData(res.data);
      }
    } catch (e) {
      console.error('Error fetching dashboard', e);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  useEffect(() => {
    fetchDashboard();
  }, []);

  const onRefresh = () => {
    setRefreshing(true);
    fetchDashboard();
  };

  const attToday = dashboardData?.attendance_today;

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar />

      <ScrollView
        contentContainerStyle={styles.scrollContent}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[colors.primary]} />}
        showsVerticalScrollIndicator={false}
      >
        {/* Unit Info Banner */}
        <View style={[styles.unitBanner, { backgroundColor: colors.primary }]}>
          <View style={styles.unitBannerContent}>
            <View>
              <Text style={styles.unitBannerBadge}>UNIT PENUGASAN AKTIF</Text>
              <Text style={styles.unitBannerName}>{unit?.name || 'Yayasan Generasi Robbani'}</Text>
              <Text style={styles.unitBannerSub}>NIP: {employee?.nip || 'PEG-2026'}</Text>
            </View>
            <View style={styles.unitCodeBox}>
              <Text style={styles.unitCodeText}>{unit?.code || 'SIT'}</Text>
            </View>
          </View>
        </View>

        {/* Attendance Quick Card */}
        <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <View style={styles.cardHeader}>
            <Text style={[styles.cardTitle, { color: colors.text }]}>⏱️ Presensi Hari Ini</Text>
            <StatusBadge
              status={attToday?.status || 'NOT_CHECKED_IN'}
              label={
                attToday?.has_checked_in
                  ? attToday?.has_checked_out
                    ? 'Sudah Selesai'
                    : 'Sudah Masuk'
                  : 'Belum Presensi'
              }
            />
          </View>

          <View style={styles.attendanceTimeRow}>
            <View style={styles.timeBox}>
              <Text style={[styles.timeLabel, { color: colors.textLight }]}>Jam Masuk</Text>
              <Text style={[styles.timeValue, { color: colors.text }]}>
                {attToday?.check_in_time ? attToday.check_in_time.substring(0, 5) : '--:--'}
              </Text>
            </View>
            <View style={styles.timeDivider} />
            <View style={styles.timeBox}>
              <Text style={[styles.timeLabel, { color: colors.textLight }]}>Jam Pulang</Text>
              <Text style={[styles.timeValue, { color: colors.text }]}>
                {attToday?.check_out_time ? attToday.check_out_time.substring(0, 5) : '--:--'}
              </Text>
            </View>
          </View>

          <TouchableOpacity
            style={[styles.primaryActionBtn, { backgroundColor: colors.primary }]}
            onPress={() => navigation.navigate('Presensi')}
            activeOpacity={0.8}
          >
            <Text style={styles.primaryActionBtnText}>
              {attToday?.has_checked_in
                ? attToday?.has_checked_out
                  ? 'Lihat Riwayat Kehadiran ➔'
                  : 'Lakukan Presensi Pulang (Selfie) ➔'
                : 'Buka Kamera Presensi Masuk (Selfie) ➔'}
            </Text>
          </TouchableOpacity>
        </View>

        {/* Geofence Radar */}
        <GeofenceRadar
          distanceMeters={attToday?.distance_meters || 45}
          maxRadiusMeters={unit?.radius_meters || 150}
          isMockDetected={false}
        />

        {/* Quick Menu 6 Grid */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>Layanan Kepegawaian &amp; SDM</Text>
        <View style={styles.gridRow}>
          <QuickActionCard
            title="Presensi Wajah"
            icon="📸"
            subtitle="Anti-Fake GPS"
            onPress={() => navigation.navigate('Presensi')}
          />
          <QuickActionCard
            title="Pengajuan Cuti"
            icon="📝"
            subtitle={`Sisa ${dashboardData?.leave_summary?.remaining_days || 10} Hari`}
            badge="IZIN"
            onPress={() => navigation.navigate('Cuti')}
          />
        </View>

        <View style={styles.gridRow}>
          <QuickActionCard
            title="Slip Gaji Digital"
            icon="💰"
            subtitle={dashboardData?.payroll_summary?.month_year || 'Bulan Ini'}
            onPress={() => navigation.navigate('Payroll')}
          />
          <QuickActionCard
            title="Evaluasi KPI"
            icon="📊"
            subtitle={`Grade ${dashboardData?.kpi_summary?.grade || 'A'} (${dashboardData?.kpi_summary?.score || 92} pts)`}
            onPress={() => navigation.navigate('Kpi')}
          />
        </View>

        <View style={styles.gridRow}>
          <QuickActionCard
            title="Kantin &amp; Koperasi"
            icon="🍽️"
            subtitle={formatRupiah(dashboardData?.wallet_balance || 350000)}
            onPress={() => navigation.navigate('Canteen')}
          />
          <QuickActionCard
            title="Memo &amp; Berita"
            icon="📢"
            subtitle="Info Terkini"
            onPress={() => navigation.navigate('Announcements')}
          />
        </View>

        {/* Sisa Cuti & Dompet Summary Cards */}
        <View style={styles.statsDoubleRow}>
          <View style={[styles.statBox, { backgroundColor: colors.surface, borderColor: colors.border }]}>
            <Text style={[styles.statLabel, { color: colors.textLight }]}>Sisa Kuota Cuti Tahunan</Text>
            <Text style={[styles.statValue, { color: colors.primary }]}>
              {dashboardData?.leave_summary?.remaining_days ?? 10}{' '}
              <Text style={styles.statUnit}>Hari</Text>
            </Text>
          </View>
          <View style={[styles.statBox, { backgroundColor: colors.surface, borderColor: colors.border }]}>
            <Text style={[styles.statLabel, { color: colors.textLight }]}>Saldo Dompet Pegawai</Text>
            <Text style={[styles.statValue, { color: '#059669' }]}>
              {formatRupiah(dashboardData?.wallet_balance || 350000)}
            </Text>
          </View>
        </View>

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
  unitBanner: {
    borderRadius: 20,
    padding: 16,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 3,
  },
  unitBannerContent: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  unitBannerBadge: {
    color: '#c6f634',
    fontSize: 9,
    fontWeight: '900',
    letterSpacing: 0.5,
    marginBottom: 2,
  },
  unitBannerName: {
    color: '#ffffff',
    fontSize: 16,
    fontWeight: '900',
  },
  unitBannerSub: {
    color: 'rgba(255,255,255,0.85)',
    fontSize: 11,
    marginTop: 2,
    fontWeight: '600',
  },
  unitCodeBox: {
    backgroundColor: 'rgba(255,255,255,0.2)',
    paddingHorizontal: 12,
    paddingVertical: 6,
    borderRadius: 12,
  },
  unitCodeText: {
    color: '#ffffff',
    fontSize: 16,
    fontWeight: '900',
  },
  card: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    marginBottom: 8,
    shadowColor: '#000',
    shadowOpacity: 0.04,
    shadowRadius: 10,
    elevation: 2,
  },
  cardHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 12,
  },
  cardTitle: {
    fontSize: 14,
    fontWeight: '800',
  },
  attendanceTimeRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-around',
    paddingVertical: 8,
  },
  timeBox: {
    alignItems: 'center',
  },
  timeLabel: {
    fontSize: 11,
    fontWeight: '600',
    marginBottom: 2,
  },
  timeValue: {
    fontSize: 18,
    fontWeight: '900',
  },
  timeDivider: {
    width: 1,
    height: 30,
    backgroundColor: 'rgba(0,0,0,0.1)',
  },
  primaryActionBtn: {
    paddingVertical: 12,
    borderRadius: 14,
    alignItems: 'center',
    marginTop: 12,
  },
  primaryActionBtnText: {
    color: '#ffffff',
    fontSize: 12,
    fontWeight: '800',
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginTop: 16,
    marginBottom: 8,
  },
  gridRow: {
    flexDirection: 'row',
    marginBottom: 2,
  },
  statsDoubleRow: {
    flexDirection: 'row',
    gap: 8,
    marginTop: 10,
  },
  statBox: {
    flex: 1,
    padding: 14,
    borderRadius: 18,
    borderWidth: 1,
  },
  statLabel: {
    fontSize: 10,
    fontWeight: '600',
    marginBottom: 4,
  },
  statValue: {
    fontSize: 16,
    fontWeight: '900',
  },
  statUnit: {
    fontSize: 12,
    fontWeight: '600',
  },
});
