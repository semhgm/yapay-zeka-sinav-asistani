import React, { createContext, useState, useEffect } from "react";
import { login as loginRequest, getAuthToken, clearAuth } from "../services/api";
import AsyncStorage from '@react-native-async-storage/async-storage';

export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [token, setToken] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const loadAuthData = async () => {
      const storedToken = await getAuthToken();
      if (storedToken) {
        setToken(storedToken);
        const storedUser = await AsyncStorage.getItem('user');
        if (storedUser) {
          setUser(JSON.parse(storedUser));
        }
      }
      setLoading(false);
    };

    loadAuthData();
  }, []);

  const login = async (email, password) => {
    try {
      const result = await loginRequest(email, password);
      setUser(result.user);
      setToken(result.token);
      return result;
    } catch (error) {
      console.error("Login Error:", error);
      throw error;
    }
  };

const logout = async () => {
  await clearAuth();
  setUser(null);
  setToken(null);
};

  if (loading) {
    return null; // or a loading spinner
  }

  return (
    <AuthContext.Provider value={{ user, token, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};