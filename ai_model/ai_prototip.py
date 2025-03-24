

import pandas as pd
from sklearn.tree import DecisionTreeClassifier

df = pd.read_csv("ai_model/dataset.csv")
df = pd.read_csv("ai_model/dataset.csv", delimiter=';')


X = df[['math_correct', 'turkish_correct', 'science_correct']]
y = df['target_weak_topic']

model = DecisionTreeClassifier()
model.fit(X, y)

new_student = pd.DataFrame([[3, 4, 2]], columns=['math_correct', 'turkish_correct', 'science_correct'])
prediction = model.predict(new_student)

print("Tahmin edilen eksik konu:", prediction[0])