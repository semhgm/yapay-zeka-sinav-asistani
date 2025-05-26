import AsyncStorage from '@react-native-async-storage/async-storage';

const API_BASE = "http://10.0.2.2:8000/api"; // Android emulator için doğru IP

export async function login(email, password) {
  try {
    const response = await fetch(`${API_BASE}/login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json"
      },
      body: JSON.stringify({ email, password })
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || "Giriş başarısız.");
    }

    // Store token and user in AsyncStorage
    await AsyncStorage.setItem('auth_token', data.token);
    await AsyncStorage.setItem('user', JSON.stringify(data.user));

    return data;
  } catch (error) {
    console.error("API login error:", error.message);
    throw error;
  }
}

export async function getAuthToken() {
  return await AsyncStorage.getItem('auth_token');
}

export async function clearAuth() {
  await AsyncStorage.removeItem('auth_token');
  await AsyncStorage.removeItem('user');
}
export async function getExamAnalyses(token) {
  // sahte veri dön
  return Promise.resolve([
    {
      id: 1,
      score: 45,
      correct_count: 5,
      wrong_count: 14,
      created_at: "2025-05-25T12:00:00Z",
      exam: { name: "TYT Genel 01" },
    },
  ]);
}