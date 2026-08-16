import apiClient from './client';

export const hrisApi = {
  // 1. Auth Login
  login: async (email, password) => {
    const response = await apiClient.post('/auth/login', { email, password });
    return response.data;
  },

  // 2. Dashboard
  getDashboard: async () => {
    const response = await apiClient.get('/dashboard');
    return response.data;
  },

  // 3. Presensi Face Recognition & Geofence
  checkIn: async ({ latitude, longitude, is_mocked, face_image }) => {
    const response = await apiClient.post('/attendance/check-in', {
      latitude,
      longitude,
      is_mocked,
      face_image,
    });
    return response.data;
  },

  checkOut: async ({ latitude, longitude, is_mocked, face_image }) => {
    const response = await apiClient.post('/attendance/check-out', {
      latitude,
      longitude,
      is_mocked,
      face_image,
    });
    return response.data;
  },

  getAttendanceHistory: async (month, year) => {
    const response = await apiClient.get('/attendance/history', {
      params: { month, year },
    });
    return response.data;
  },

  // 4. Izin & Cuti
  getLeaves: async () => {
    const response = await apiClient.get('/leaves');
    return response.data;
  },

  applyLeave: async (data) => {
    const response = await apiClient.post('/leaves/apply', data);
    return response.data;
  },

  // 5. Payroll & Slip Gaji
  getPayroll: async () => {
    const response = await apiClient.get('/payroll');
    return response.data;
  },

  getPayrollSlip: async (id) => {
    const response = await apiClient.get(`/payroll/${id}/slip`);
    return response.data;
  },

  // 6. Penilaian Kinerja & KPI
  getKpi: async () => {
    const response = await apiClient.get('/kpi');
    return response.data;
  },

  // 7. Belanja Kantin / Koperasi
  getCanteenProducts: async () => {
    const response = await apiClient.get('/canteen/products');
    return response.data;
  },

  payCanteen: async (productId, amount) => {
    const response = await apiClient.post('/canteen/pay', {
      product_id: productId,
      amount,
    });
    return response.data;
  },

  // 8. Pengumuman
  getAnnouncements: async () => {
    const response = await apiClient.get('/announcements');
    return response.data;
  },

  // 9. BPI (Bina Pribadi Islam) & Mutabaah Yaumiyah SDM
  getBpiGroup: async () => {
    const response = await apiClient.get('/bpi/my-group');
    return response.data;
  },

  getTodayMutabaah: async () => {
    const response = await apiClient.get('/bpi/mutabaah/today');
    return response.data;
  },

  saveTodayMutabaah: async (data) => {
    const response = await apiClient.post('/bpi/mutabaah/save', data);
    return response.data;
  },

  getMutabaahHistory: async (month, year) => {
    const response = await apiClient.get('/bpi/mutabaah/history', {
      params: { month, year },
    });
    return response.data;
  },

  getMentorDashboard: async () => {
    const response = await apiClient.get('/bpi/mentor/dashboard');
    return response.data;
  },

  saveBpiMeeting: async (data) => {
    const response = await apiClient.post('/bpi/meetings/record', data);
    return response.data;
  },
};
