import React, { useState } from 'react';
import { View, Text, StyleSheet, Modal, TouchableOpacity, Image } from 'react-native';
import { useTheme } from '../context/ThemeContext';

export default function FaceCameraModal({ visible, onClose, onCapture, mode = 'check-in' }) {
  const { colors } = useTheme();
  const [isSimulating, setIsSimulating] = useState(false);

  const handleSnap = () => {
    setIsSimulating(true);
    setTimeout(() => {
      setIsSimulating(false);
      onCapture({
        uri: 'file://selfie_verified_' + Date.now() + '.jpg',
        base64: 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD...',
      });
      onClose();
    }, 1000);
  };

  return (
    <Modal visible={visible} animationType="slide" transparent onRequestClose={onClose}>
      <View style={styles.modalOverlay}>
        <View style={[styles.modalContent, { backgroundColor: colors.surface }]}>
          
          <View style={styles.header}>
            <Text style={[styles.title, { color: colors.text }]}>
              👤 Verifikasi Wajah (Face Recognition)
            </Text>
            <TouchableOpacity onPress={onClose} style={styles.closeBtn}>
              <Text style={styles.closeBtnText}>✕</Text>
            </TouchableOpacity>
          </View>

          <Text style={[styles.guideText, { color: colors.textLight }]}>
            Posisikan wajah Anda tegak lurus di dalam bingkai oval di bawah ini dengan pencahayaan yang cukup.
          </Text>

          {/* Camera Viewfinder & Face Frame */}
          <View style={styles.viewfinderContainer}>
            <Image
              source={{ uri: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=400' }}
              style={styles.cameraPlaceholder}
            />
            <View style={[styles.faceOvalFrame, { borderColor: colors.primary }]}>
              <View style={styles.faceCrosshair} />
            </View>
            <View style={styles.livenessBadge}>
              <Text style={styles.livenessText}>🟢 Deteksi Wajah Aktif (Liveness OK)</Text>
            </View>
          </View>

          {/* Action Buttons */}
          <View style={styles.actionRow}>
            <TouchableOpacity
              style={[styles.cancelBtn, { borderColor: colors.border }]}
              onPress={onClose}
              activeOpacity={0.7}
            >
              <Text style={[styles.cancelBtnText, { color: colors.text }]}>Batal</Text>
            </TouchableOpacity>

            <TouchableOpacity
              style={[styles.captureBtn, { backgroundColor: colors.primary }]}
              onPress={handleSnap}
              disabled={isSimulating}
              activeOpacity={0.8}
            >
              <Text style={styles.captureBtnText}>
                {isSimulating ? 'Memproses Wajah...' : mode === 'check-in' ? '📸 Konfirmasi Presensi Masuk' : '📸 Konfirmasi Presensi Pulang'}
              </Text>
            </TouchableOpacity>
          </View>

        </View>
      </View>
    </Modal>
  );
}

const styles = StyleSheet.create({
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0,0,0,0.7)',
    justifyContent: 'flex-end',
  },
  modalContent: {
    borderTopLeftRadius: 28,
    borderTopRightRadius: 28,
    padding: 20,
    maxHeight: '90%',
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  title: {
    fontSize: 15,
    fontWeight: '800',
  },
  closeBtn: {
    width: 32,
    height: 32,
    borderRadius: 16,
    backgroundColor: 'rgba(0,0,0,0.06)',
    alignItems: 'center',
    justifyContent: 'center',
  },
  closeBtnText: {
    fontSize: 14,
    fontWeight: 'bold',
  },
  guideText: {
    fontSize: 12,
    marginBottom: 16,
    lineHeight: 16,
  },
  viewfinderContainer: {
    height: 320,
    borderRadius: 24,
    overflow: 'hidden',
    position: 'relative',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#0f172a',
  },
  cameraPlaceholder: {
    width: '100%',
    height: '100%',
    opacity: 0.85,
  },
  faceOvalFrame: {
    position: 'absolute',
    width: 180,
    height: 240,
    borderRadius: 90,
    borderWidth: 3,
    borderStyle: 'dashed',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: 'rgba(255,255,255,0.05)',
  },
  faceCrosshair: {
    width: 16,
    height: 16,
    borderRadius: 8,
    backgroundColor: 'rgba(255,255,255,0.6)',
  },
  livenessBadge: {
    position: 'absolute',
    bottom: 12,
    backgroundColor: 'rgba(0,0,0,0.65)',
    paddingHorizontal: 12,
    paddingVertical: 5,
    borderRadius: 12,
  },
  livenessText: {
    color: '#34d399',
    fontSize: 10,
    fontWeight: '800',
  },
  actionRow: {
    flexDirection: 'row',
    gap: 10,
    marginTop: 20,
  },
  cancelBtn: {
    flex: 1,
    paddingVertical: 14,
    borderRadius: 16,
    borderWidth: 1,
    alignItems: 'center',
  },
  cancelBtnText: {
    fontSize: 13,
    fontWeight: '700',
  },
  captureBtn: {
    flex: 2,
    paddingVertical: 14,
    borderRadius: 16,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOpacity: 0.15,
    shadowRadius: 8,
    elevation: 3,
  },
  captureBtnText: {
    color: '#ffffff',
    fontSize: 13,
    fontWeight: '900',
  },
});
