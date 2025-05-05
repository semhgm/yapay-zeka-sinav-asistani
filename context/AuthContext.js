import React, { createContext, useState } from 'react';

export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [role, setRole] = useState(null);

  const login = (email, password) => {
    if (email.includes('admin')) setRole('superadmin');
    else if (email.includes('hoca')) setRole('hoca');
    else setRole('ogrenci');
  };

  return (
    <AuthContext.Provider value={{ role, login }}>
      {children}
    </AuthContext.Provider>
  );
};