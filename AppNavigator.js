import React, { useContext } from "react";
import { createNativeStackNavigator } from "@react-navigation/native-stack";
import { AuthContext } from "./context/AuthContext";

import LoginScreen from "./screens/LoginScreen";
import DashboardStudent from "./screens/DashboardStudent";
import CalendarScreen from "./screens/CalendarScreen";
import StudyPlanScreen from "./screens/StudyPlanScreen";
import ExamAnalysisScreen from "./screens/ExamAnalysisScreen";
import NotesScreen from "./screens/NotesScreen";
import NotificationScreen from "./screens/NotificationScreen"; // <-- eksikti, eklendi

const Stack = createNativeStackNavigator();

export default function AppNavigator() {
  const { user } = useContext(AuthContext);

  if (user === null) {
    return (
      <Stack.Navigator screenOptions={{ headerShown: false }}>
        <Stack.Screen name="Login" component={LoginScreen} />
      </Stack.Navigator>
    );
  }

  return (
    <Stack.Navigator screenOptions={{ headerShown: true }}>
      <Stack.Screen name="Dashboard" component={DashboardStudent} />
      <Stack.Screen name="Calendar" component={CalendarScreen} />
      <Stack.Screen name="StudyPlan" component={StudyPlanScreen} />
      <Stack.Screen name="ExamAnalysis" component={ExamAnalysisScreen} />
      <Stack.Screen name="Notes" component={NotesScreen} />
      <Stack.Screen name="Notifications" component={NotificationScreen} />
    </Stack.Navigator>
  );
}