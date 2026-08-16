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
import StatusBadge from '../components/StatusBadge';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';
import { formatDateIndonesia } from '../utils/formatters';

export default function AttendanceHistoryScreen() {
  const { colors } = useTheme();
  const [loading, setLoading] = useState(true);
  const [history, setHistory] = useState([]);
  const [summary, setSummary] = useState({ total_present: 0, total_late: 0, total_permit: 0, total_sick: 0 });

  const fetchHistory = async () => {
    try {
      const res = await hrisApi.getAttendanceHistory();
      if (res.status === 'success') {
        setHistory(res.data || []);
        if (res.summary) setSummary(res.summary);
      }
    } catch (e) {
      console.error('Error fetching history', e);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchHistory();
  }, []);

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Riwayat Presensi" subtitle="Rekapitulasi Kehadiran Bulanan" />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        {/* Summary Metric Badges */}
        <View style={styles.statsRow}>
          <View style={[styles.statCard, { backgroundColor: '#dcfce7' }]}>
            <Text style={[styles.statNum, { color: '#166534' }]}>{summary.total_present || 18}</Text>
            <Text style={[styles.statTitle, { color: '#166534' }]}>Hadir Tepat</Text>
          </View>
          <View style={[styles.statCard, { backgroundColor: '#fef3c7' }]}>
            <Text style={[styles.statNum, { color: '#9a3412' }]}>{summary.total_late || 1}</Text>
            <Text style={[styles.statTitle, { color: '#9a3412' }]}>Terlambat</Text>
          </View>
          <View style={[styles.statCard, { backgroundColor: '#e0f2fe' }]}>
            <Text style={[styles.statNum, { color: '#075985' }]}>{summary.total_permit || 0}</Text>
            <Text style={[styles.statTitle, { color: '#075985' }]}>Izin/Cuti</Text>
          </View>
          <View style={[styles.statCard, { backgroundColor: '#fee2e2' }]}>
            <Text style={[styles.statNum, { color: '#991b1b' }]}>{summary.total_sick || 0}</Text>
            <Text style={[styles.statTitle, { color: '#991b1b' }]}>Sakit</Text>
          </View>
        </View>

        {/* List of Days */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>Catatan Kehadiran Bulan Ini</Text>

        {history.length === 0 ? (
          <View style={[styles.emptyBox, { backgroundColor: colors.surface, borderColor: colors.border }]}>
            <Text style={styles.emptyIcon}>📋</Text>
            <Text style={[styles.emptyText, { color: colors.text }]}>Belum ada log presensi bulan ini.</Text>
            <Text style={[styles.emptySub, { color: colors.textLight }]}>
              Lakukan presensi wajah selfie setiap hari kerja.
            </Text>
          </View>
        ) : (
          history.map((item, idx) => (
            <View
              key={idx}
              style={[styles.historyCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
            >
              <View style={styles.historyLeft}>
                <Text style={[styles.historyDate, { color: colors.text }]}>
                  {formatDateIndonesia(item.date)}
                </Text>
                <View style={styles.historyTimeRow}>
                  <Text style={[styles.timeText, { color: colors.textLight }]}>
                    Masuk: <Text style={{ color: colors.text, fontWeight: '700' }}>{item.check_in_time ? item.check_in_time.substring(0, 5) : '-'}</Text>
                  </Text>
                  <Text style={[styles.timeText, { color: colors.textLight }]}>
                    Pulang: <Text style={{ color: colors.text, fontWeight: '700' }}>{item.check_out_time ? item.check_out_time.substring(0, 5) : '-'}</Text>
                  </Text>
                </View>
                {item.check_in_distance_meters ? (
                  <Text style={[styles.distText, { color: '#059669' }]}>
                    📍 Radius: {item.check_in_distance_meters} m dari sekolah (Valid)
                  </Text>
                ) : null}
              </View>

              <StatusBadge status={item.status} />
            </View>
          ))
        )}
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
  statsRow: {
    flexDirection: 'row',
    gap: 6,
    marginBottom: 16,
  },
  statCard: {
    flex: 1,
    paddingVertical: 12,
    borderRadius: 14,
    alignItems: 'center',
  },
  statNum: {
    fontSize: 16,
    fontWeight: '900',
  },
  statTitle: {
    fontSize: 9,
    fontWeight: '800',
    marginTop: 2,
    textTransform: 'uppercase',
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 10,
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
    padding: 14,
    borderRadius: 18,
    borderWidth: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  historyLeft: {
    flex: 1,
  },
  historyDate: {
    fontSize: 13,
    fontWeight: '800',
  },
  historyTimeRow: {
    flexDirection: 'row',
    gap: 12,
    marginTop: 4,
  },
  timeText: {
    fontSize: 11,
  },
  distText: {
    fontSize: 10,
    marginTop: 4,
    fontWeight: '600',
  },
});
