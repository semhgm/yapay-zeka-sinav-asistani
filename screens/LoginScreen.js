import React, { useState, useContext } from 'react';
import { View, Text, TextInput, Button, StyleSheet, Alert } from 'react-native';
import { AuthContext } from '../context/AuthContext';
import { login } from '../services/api';

export default function LoginScreen() {
  const { login: loginWithRole } = useContext(AuthContext); // ismini değiştirdik, çakışmasın
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleLogin = async () => {
    try {
    
      const result = await login(email, password);
      loginWithRole(result.role); // AuthContext içindeki fonksiyon
    } catch (e) {
      Alert.alert('Hata', 'Giriş başarısız');
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Sınav Asistanı</Text>
      <TextInput
        placeholder="E-posta"
        style={styles.input}
        value={email}
        onChangeText={setEmail}
      />
      <TextInput
        placeholder="Şifre"
        secureTextEntry
        style={styles.input}
        value={password}
        onChangeText={setPassword}
      />
      <Button title="GİRİŞ YAP" onPress={handleLogin} />
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, justifyContent: 'center', padding: 20 },
  title: { fontSize: 28, fontWeight: 'bold', textAlign: 'center', marginBottom: 20 },
  input: { borderWidth: 1, padding: 10, marginBottom: 15, borderRadius: 8 }
});