import React, { useContext } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { AuthProvider, AuthContext } from './context/AuthContext';
import LoginScreen from './screens/LoginScreen';
import DashboardSuperadmin from './screens/DashboardSuperadmin';
import DashboardTeacher from './screens/DashboardTeacher';
import DashboardStudent from './screens/DashboardStudent';

const Stack = createNativeStackNavigator();

function AppNavigator() {
  const { role } = useContext(AuthContext);

  if (!role) return <LoginScreen />;
  if (role === 'superadmin') return <DashboardSuperadmin />;
  if (role === 'teacher') return <DashboardTeacher />;
  return <DashboardStudent />;
}

export default function App() {
  return (
    <AuthProvider>
      <NavigationContainer>
        <AppNavigator />
      </NavigationContainer>
    </AuthProvider>
  );
}