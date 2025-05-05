const BASE_URL = 'http://10.192.37.155:8000/api';

export async function getStudentProgress(userId) {
  const res = await fetch(`${BASE_URL}/progress/${userId}`);
  return await res.json();
}

export async function login(email, password) {
  const res = await fetch(`${BASE_URL}/mobil/login`, {
    method: 'POST', // POST isteği
    headers: {
      'Content-Type': 'application/json' // JSON body olduğunu belirt
    },
    body: JSON.stringify({ email, password }) // Laravel bu şekilde body'den alır
  });

  if (!res.ok) {
    const error = await res.json();
    console.log('Login error:', error); 
    throw new Error(error.message || 'Giriş başarısız');
  }

  return await res.json();
}
    
    