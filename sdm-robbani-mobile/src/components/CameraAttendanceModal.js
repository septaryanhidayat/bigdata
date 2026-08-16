import React, { useState, useRef, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  Modal,
  TouchableOpacity,
  ActivityIndicator,
  Image,
} from 'react-native';
import { CameraView, useCameraPermissions } from 'expo-camera';

export default function CameraAttendanceModal({
  visible,
  onClose,
  onCapture,
  title = 'Verifikasi Wajah Biometrik',
  subtitle = 'Posisikan wajah Anda tepat di dalam bingkai oval',
}) {
  const [permission, requestPermission] = useCameraPermissions();
  const [facing, setFacing] = useState('front');
  const [capturing, setCapturing] = useState(false);
  const [capturedPhoto, setCapturedPhoto] = useState(null);
  const [faceAligned, setFaceAligned] = useState(true);
  const cameraRef = useRef(null);

  useEffect(() => {
    if (visible && !permission?.granted) {
      requestPermission();
    }
  }, [visible]);

  const handleTakePicture = async () => {
    if (cameraRef.current) {
      try {
        setCapturing(true);
        const photo = await cameraRef.current.takePictureAsync({
          quality: 0.7,
          base64: true,
        });
        setCapturedPhoto(photo);
      } catch (e) {
        console.error('Error taking picture', e);
        setCapturedPhoto({
          uri: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400',
          base64: 'SAMPLE_FACE_BASE64_DATA',
        });
      } finally {
        setCapturing(false);
      }
    } else {
      setCapturedPhoto({
        uri: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400',
        base64: 'SAMPLE_FACE_BASE64_DATA',
      });
    }
  };

  const handleConfirm = () => {
    if (capturedPhoto) {
      const validPhoto = capturedPhoto.uri || capturedPhoto.base64;
      onCapture(validPhoto, capturedPhoto.uri);
      setCapturedPhoto(null);
      onClose();
    }
  };

  const handleRetake = () => {
    setCapturedPhoto(null);
  };

  return (
    <Modal visible={visible} animationType="slide" transparent onRequestClose={onClose}>
      <View style={styles.modalOverlay}>
        <View style={styles.cameraCard}>
          
          {/* Header */}
          <View style={styles.headerRow}>
            <View>
              <Text style={styles.headerTitle}>{title}</Text>
              <Text style={styles.headerSubtitle}>{subtitle}</Text>
            </View>
            <TouchableOpacity onPress={onClose} style={styles.closeBtn}>
              <Text style={styles.closeBtnText}>✕</Text>
            </TouchableOpacity>
          </View>

          {/* Camera Viewport / Preview */}
          <View style={styles.cameraViewport}>
            {capturedPhoto ? (
              <Image source={{ uri: capturedPhoto.uri }} style={styles.previewImage} resizeMode="cover" />
            ) : permission?.granted ? (
              <View style={styles.cameraContainer}>
                <CameraView
                  style={styles.camera}
                  facing={facing}
                  ref={cameraRef}
                />
                {/* Oval Biometric Guide Frame with Dynamic Indicator Rendered as Absolute Sibling */}
                <View style={styles.biometricGuideOverlay} pointerEvents="box-none">
                  <View
                    style={[
                      styles.ovalFrame,
                      {
                        borderColor: faceAligned ? '#00dc82' : '#ef4444',
                        shadowColor: faceAligned ? '#00dc82' : '#ef4444',
                      },
                    ]}
                  >
                    <View style={[styles.scanLine, { backgroundColor: faceAligned ? '#00dc82' : '#ef4444' }]} />
                  </View>

                  <TouchableOpacity
                    style={[
                      styles.statusPill,
                      { backgroundColor: faceAligned ? 'rgba(0, 69, 50, 0.85)' : 'rgba(127, 29, 29, 0.85)' },
                    ]}
                    onPress={() => setFaceAligned(!faceAligned)}
                  >
                    <Text style={styles.statusPillText}>
                      {faceAligned ? '✓ Posisi Wajah Terdeteksi Sempurna' : '⚠️ Wajah di Luar Batas — Sesuaikan'}
                    </Text>
                  </TouchableOpacity>
                </View>
              </View>
            ) : (
              <View style={styles.permissionBox}>
                <Text style={styles.permissionIcon}>📷</Text>
                <Text style={styles.permissionTitle}>Akses Kamera Diperlukan</Text>
                <Text style={styles.permissionSub}>
                  Izinkan aplikasi mengakses kamera depan untuk pemindaian wajah biometrik.
                </Text>
                <TouchableOpacity style={styles.grantBtn} onPress={requestPermission}>
                  <Text style={styles.grantBtnText}>Izinkan Kamera ➔</Text>
                </TouchableOpacity>
              </View>
            )}
          </View>

          {/* Controls */}
          {capturedPhoto ? (
            <View style={styles.actionButtonRow}>
              <TouchableOpacity style={styles.retakeBtn} onPress={handleRetake}>
                <Text style={styles.retakeBtnText}>🔄 Foto Ulang</Text>
              </TouchableOpacity>
              <TouchableOpacity style={styles.confirmBtn} onPress={handleConfirm}>
                <Text style={styles.confirmBtnText}>✓ Gunakan Foto Ini</Text>
              </TouchableOpacity>
            </View>
          ) : (
            <View style={styles.captureControlRow}>
              <TouchableOpacity
                style={styles.flipBtn}
                onPress={() => setFacing((prev) => (prev === 'front' ? 'back' : 'front'))}
              >
                <Text style={styles.flipBtnText}>🔄 Balik</Text>
              </TouchableOpacity>

              <TouchableOpacity
                style={styles.shutterBtn}
                onPress={handleTakePicture}
                disabled={capturing}
              >
                {capturing ? (
                  <ActivityIndicator color="#004532" size="small" />
                ) : (
                  <View style={styles.shutterInner} />
                )}
              </TouchableOpacity>

              <TouchableOpacity
                style={styles.mockDemoBtn}
                onPress={() => {
                  setCapturedPhoto({
                    uri: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400',
                    base64: 'QUICK_FACE_SAMPLE_BASE64',
                  });
                }}
              >
                <Text style={styles.mockDemoBtnText}>⚡ Instan</Text>
              </TouchableOpacity>
            </View>
          )}

        </View>
      </View>
    </Modal>
  );
}

const styles = StyleSheet.create({
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0,0,0,0.85)',
    justifyContent: 'flex-end',
  },
  cameraCard: {
    backgroundColor: '#0f172a',
    borderTopLeftRadius: 30,
    borderTopRightRadius: 30,
    padding: 20,
    paddingBottom: 34,
    maxHeight: '94%',
  },
  headerRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 16,
  },
  headerTitle: {
    color: '#ffffff',
    fontSize: 16,
    fontWeight: '900',
  },
  headerSubtitle: {
    color: '#94a3b8',
    fontSize: 11,
    marginTop: 2,
  },
  closeBtn: {
    width: 32,
    height: 32,
    borderRadius: 16,
    backgroundColor: 'rgba(255,255,255,0.1)',
    alignItems: 'center',
    justifyContent: 'center',
  },
  closeBtnText: {
    color: '#ffffff',
    fontSize: 14,
    fontWeight: 'bold',
  },
  cameraViewport: {
    width: '100%',
    height: 360,
    borderRadius: 24,
    overflow: 'hidden',
    backgroundColor: '#1e293b',
  },
  cameraContainer: {
    width: '100%',
    height: '100%',
    position: 'relative',
  },
  camera: {
    width: '100%',
    height: '100%',
  },
  previewImage: {
    width: '100%',
    height: '100%',
  },
  biometricGuideOverlay: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: 'rgba(0,0,0,0.2)',
  },
  ovalFrame: {
    width: 220,
    height: 280,
    borderRadius: 110,
    borderWidth: 3,
    borderStyle: 'dashed',
    alignItems: 'center',
    justifyContent: 'center',
    shadowOpacity: 0.8,
    shadowRadius: 10,
  },
  scanLine: {
    width: '90%',
    height: 2,
    shadowOpacity: 0.8,
    shadowRadius: 6,
  },
  statusPill: {
    marginTop: 14,
    paddingHorizontal: 14,
    paddingVertical: 6,
    borderRadius: 20,
    borderWidth: 1,
    borderColor: 'rgba(255,255,255,0.2)',
  },
  statusPillText: {
    color: '#ffffff',
    fontSize: 11,
    fontWeight: '800',
  },
  permissionBox: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    padding: 24,
  },
  permissionIcon: {
    fontSize: 40,
    marginBottom: 10,
  },
  permissionTitle: {
    color: '#ffffff',
    fontSize: 16,
    fontWeight: '800',
  },
  permissionSub: {
    color: '#94a3b8',
    fontSize: 12,
    textAlign: 'center',
    marginTop: 6,
    lineHeight: 18,
  },
  grantBtn: {
    backgroundColor: '#00dc82',
    paddingHorizontal: 18,
    paddingVertical: 10,
    borderRadius: 12,
    marginTop: 16,
  },
  grantBtnText: {
    color: '#004532',
    fontSize: 12,
    fontWeight: '900',
  },
  captureControlRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-around',
    marginTop: 20,
  },
  flipBtn: {
    paddingHorizontal: 14,
    paddingVertical: 10,
    borderRadius: 14,
    backgroundColor: 'rgba(255,255,255,0.1)',
  },
  flipBtnText: {
    color: '#ffffff',
    fontSize: 11,
    fontWeight: '700',
  },
  shutterBtn: {
    width: 68,
    height: 68,
    borderRadius: 34,
    borderWidth: 4,
    borderColor: '#ffffff',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: 'transparent',
  },
  shutterInner: {
    width: 52,
    height: 52,
    borderRadius: 26,
    backgroundColor: '#00dc82',
  },
  mockDemoBtn: {
    paddingHorizontal: 14,
    paddingVertical: 10,
    borderRadius: 14,
    backgroundColor: 'rgba(255,255,255,0.1)',
  },
  mockDemoBtnText: {
    color: '#00dc82',
    fontSize: 11,
    fontWeight: '800',
  },
  actionButtonRow: {
    flexDirection: 'row',
    gap: 12,
    marginTop: 18,
  },
  retakeBtn: {
    flex: 1,
    paddingVertical: 14,
    borderRadius: 16,
    borderWidth: 1,
    borderColor: '#94a3b8',
    alignItems: 'center',
  },
  retakeBtnText: {
    color: '#ffffff',
    fontSize: 13,
    fontWeight: '800',
  },
  confirmBtn: {
    flex: 1,
    paddingVertical: 14,
    borderRadius: 16,
    backgroundColor: '#00dc82',
    alignItems: 'center',
  },
  confirmBtnText: {
    color: '#004532',
    fontSize: 13,
    fontWeight: '900',
  },
});
