import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, ScrollView } from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';

export default function KpiScreen() {
  const { colors } = useTheme();
  const [kpiData, setKpiData] = useState(null);

  useEffect(() => {
    const fetchKpi = async () => {
      try {
        const res = await hrisApi.getKpi();
        if (res.status === 'success' && res.data?.length > 0) {
          setKpiData(res.data[0]);
        }
      } catch (e) {
        console.error('Error fetching KPI', e);
      }
    };
    fetchKpi();
  }, []);

  const metrics = [
    { name: 'Kompetensi Pedagogik & Pengajaran', score: kpiData?.pedagogic_score || 92.0, max: 100, icon: '📖' },
    { name: 'Keteladanan Kepribadian & Akhlaq', score: kpiData?.personality_score || 95.0, max: 100, icon: '🌟' },
    { name: 'Komunikasi Sosial & Kerjasama Tim', score: kpiData?.social_score || 90.0, max: 100, icon: '🤝' },
    { name: 'Wawasan Keislaman & BPI Yaumiyah', score: kpiData?.islamic_score || 96.0, max: 100, icon: '🕌' },
    { name: 'Kedisiplinan & Presensi Jam Kerja', score: kpiData?.discipline_attendance_score || 94.0, max: 100, icon: '⏱️' },
  ];

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Penilaian Kinerja (KPI)" subtitle="Indikator Capaian Kinerja SDM" />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* KPI Score Card */}
        <View style={[styles.kpiCard, { backgroundColor: colors.primary }]}>
          <Text style={styles.kpiBadge}>SKOR AKHIR EVALUASI KINERJA (SEMESTER)</Text>
          <View style={styles.kpiScoreRow}>
            <Text style={styles.kpiScoreBig}>{kpiData?.final_score || 93.4}</Text>
            <View style={styles.gradeCircle}>
              <Text style={styles.gradeText}>{kpiData?.grade || 'A'}</Text>
            </View>
          </View>
          <Text style={styles.kpiStatus}>Predikat: SANGAT MEMUASKAN (EXCELLENT)</Text>
        </View>

        {/* Breakdown Dimensions */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>Rincian 5 Dimensi Penilaian</Text>

        {metrics.map((item, idx) => (
          <View
            key={idx}
            style={[styles.metricCard, { backgroundColor: colors.surface, borderColor: colors.border }]}
          >
            <View style={styles.metricHeader}>
              <View style={styles.metricLeft}>
                <Text style={styles.metricIcon}>{item.icon}</Text>
                <Text style={[styles.metricName, { color: colors.text }]}>{item.name}</Text>
              </View>
              <Text style={[styles.metricScoreText, { color: colors.primary }]}>
                {item.score} <Text style={styles.maxText}>/ 100</Text>
              </Text>
            </View>

            {/* Progress Bar */}
            <View style={[styles.progressBarBg, { backgroundColor: colors.surfaceSub }]}>
              <View
                style={[
                  styles.progressBarFill,
                  { width: `${item.score}%`, backgroundColor: colors.primary },
                ]}
              />
            </View>
          </View>
        ))}

        {/* Evaluator Notes Card */}
        <View style={[styles.noteCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Text style={[styles.noteTitle, { color: colors.text }]}>💬 Catatan Evaluator &amp; Pimpinan:</Text>
          <Text style={[styles.noteContent, { color: colors.textLight }]}>
            "{kpiData?.evaluator_notes || 'Kinerja mengajar dan teladan kepribadian Islami sangat baik. Pertahankan kedisiplinan dan inovasi pembelajaran berbasis digital.'}"
          </Text>
          <Text style={[styles.evaluatorSign, { color: colors.primary }]}>
            — Tim Penilai Kinerja SDM SIT Robbani
          </Text>
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
  kpiCard: {
    borderRadius: 22,
    padding: 20,
    alignItems: 'center',
    marginBottom: 16,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 3,
  },
  kpiBadge: {
    color: '#c6f634',
    fontSize: 9,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  kpiScoreRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 16,
    marginVertical: 8,
  },
  kpiScoreBig: {
    color: '#ffffff',
    fontSize: 44,
    fontWeight: '900',
  },
  gradeCircle: {
    width: 48,
    height: 48,
    borderRadius: 24,
    backgroundColor: '#c6f634',
    alignItems: 'center',
    justifyContent: 'center',
  },
  gradeText: {
    color: '#061107',
    fontSize: 24,
    fontWeight: '900',
  },
  kpiStatus: {
    color: 'rgba(255,255,255,0.95)',
    fontSize: 11,
    fontWeight: '800',
    letterSpacing: 0.5,
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 10,
  },
  metricCard: {
    padding: 14,
    borderRadius: 16,
    borderWidth: 1,
    marginBottom: 8,
  },
  metricHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  metricLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    flex: 1,
    marginRight: 8,
  },
  metricIcon: {
    fontSize: 16,
    marginRight: 8,
  },
  metricName: {
    fontSize: 12,
    fontWeight: '700',
    flex: 1,
  },
  metricScoreText: {
    fontSize: 14,
    fontWeight: '900',
  },
  maxText: {
    fontSize: 10,
    fontWeight: '600',
    color: '#94a3b8',
  },
  progressBarBg: {
    height: 6,
    borderRadius: 3,
    overflow: 'hidden',
  },
  progressBarFill: {
    height: '100%',
    borderRadius: 3,
  },
  noteCard: {
    padding: 16,
    borderRadius: 18,
    borderWidth: 1,
    marginTop: 10,
  },
  noteTitle: {
    fontSize: 13,
    fontWeight: '800',
    marginBottom: 6,
  },
  noteContent: {
    fontSize: 12,
    fontStyle: 'italic',
    lineHeight: 18,
  },
  evaluatorSign: {
    fontSize: 11,
    fontWeight: '800',
    marginTop: 8,
    textAlign: 'right',
  },
});
