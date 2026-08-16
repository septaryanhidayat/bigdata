import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, ScrollView } from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';

export default function AnnouncementScreen() {
  const { colors } = useTheme();
  const [announcements, setAnnouncements] = useState([]);

  useEffect(() => {
    const fetchAnnouncements = async () => {
      try {
        const res = await hrisApi.getAnnouncements();
        if (res.status === 'success') {
          setAnnouncements(res.data || []);
        }
      } catch (e) {
        console.error('Error fetching announcements', e);
      }
    };
    fetchAnnouncements();
  }, []);

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Memo &amp; Informasi" subtitle="Pengumuman Resmi Yayasan &amp; Unit" />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        {announcements.map((item) => (
          <View
            key={item.id}
            style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}
          >
            <View style={styles.headerRow}>
              <View style={[styles.badge, { backgroundColor: item.badge_color || colors.primary }]}>
                <Text style={styles.badgeText}>{item.category}</Text>
              </View>
              <Text style={[styles.dateText, { color: colors.textLight }]}>{item.date}</Text>
            </View>

            <Text style={[styles.title, { color: colors.text }]}>{item.title}</Text>
            <Text style={[styles.content, { color: colors.textLight }]}>{item.content}</Text>
          </View>
        ))}
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
  card: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOpacity: 0.04,
    shadowRadius: 8,
    elevation: 2,
  },
  headerRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  badge: {
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 6,
  },
  badgeText: {
    color: '#ffffff',
    fontSize: 9,
    fontWeight: '900',
    textTransform: 'uppercase',
  },
  dateText: {
    fontSize: 11,
    fontWeight: '600',
  },
  title: {
    fontSize: 14,
    fontWeight: '800',
    lineHeight: 20,
    marginBottom: 6,
  },
  content: {
    fontSize: 12,
    lineHeight: 18,
  },
});
