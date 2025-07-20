import React, { useState } from "react";
import "./login.css";
import leftImage from "../../images/Group 13.png";
import combinedLogo from "../../images/Group 131.png";
import EgyptFlag from "../../images/egypt.svg";
import UKFlag from "../../images/united-kingdom.svg";
import eTaxLogo from "../../images/eTax New logo.svg";
import api from "../api.js";

const Login = () => {
  const [formData, setFormData] = useState({
    email: '',
    password: ''
  });
  
  const [errors, setErrors] = useState({
    email: '',
    password: ''
  });
  
  const [touched, setTouched] = useState({
    email: false,
    password: false
  });
  
  const [loading, setLoading] = useState(false);
  const [submitError, setSubmitError] = useState('');

  // Frontend validation rules
  const validateField = (name, value) => {
    switch (name) {
      case 'email':
        if (!value) return 'البريد الإلكتروني مطلوب';
        if (!/\S+@\S+\.\S+/.test(value)) return 'البريد الإلكتروني غير صحيح';
        return '';
      
      case 'password':
        if (!value) return 'كلمة المرور مطلوبة';
        if (value.length < 6) return 'كلمة المرور يجب أن تكون 6 أحرف على الأقل';
        return '';
      
      default:
        return '';
    }
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));

    // Clear error when user starts typing
    if (errors[name]) {
      setErrors(prev => ({
        ...prev,
        [name]: ''
      }));
    }
  };

  const handleInputBlur = (e) => {
    const { name, value } = e.target;
    
    // Mark field as touched
    setTouched(prev => ({
      ...prev,
      [name]: true
    }));

    // Validate field
    const error = validateField(name, value);
    setErrors(prev => ({
      ...prev,
      [name]: error
    }));
  };

  const handleInputClick = (e) => {
    const { name, value } = e.target;
    
    // If field is touched and has value, validate on click
    if (touched[name] && value) {
      const error = validateField(name, value);
      setErrors(prev => ({
        ...prev,
        [name]: error
      }));
    }
  };

  const validateForm = () => {
    const newErrors = {
      email: validateField('email', formData.email),
      password: validateField('password', formData.password)
    };

    setErrors(newErrors);
    
    // Mark all fields as touched
    setTouched({
      email: true,
      password: true
    });

    return !newErrors.email && !newErrors.password;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setSubmitError('');

    // Validate form before submission
    if (!validateForm()) {
      return;
    }

    setLoading(true);

    try {
      const response = await api.post('/auth/login', formData);
      
      // Store the token in localStorage
      localStorage.setItem('access_token', response.data.access_token);
      localStorage.setItem('user', JSON.stringify(response.data.user));
      
      // Set the default Authorization header for future requests
      api.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`;
      
      // Redirect to dashboard or home page
      console.log('Login successful:', response.data);
      // window.location.href = '/dashboard'; // or use React Router
      
    } catch (error) {
      console.error('Login error:', error);
      
      // Handle backend validation errors
      if (error.response?.data?.errors) {
        const backendErrors = error.response.data.errors;
        setErrors({
          email: backendErrors.email ? backendErrors.email[0] : '',
          password: backendErrors.password ? backendErrors.password[0] : ''
        });
      } else if (error.response?.data?.error) {
        setSubmitError(error.response.data.error);
      } else {
        setSubmitError('حدث خطأ أثناء تسجيل الدخول. يرجى المحاولة مرة أخرى.');
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="login-root">
      <div className="login-container ">
        <div className="login-image-section no-clip">
          <img
            src={leftImage}
            alt="login visual"
            className="login-image-full no-mirror"
            draggable="false"
          />
        </div>
        <div className="login-form-section">
          <div className="login-header">
            <img src={combinedLogo} alt="combined logo" className="login-combined-logo" draggable="false" />
            <h1 className="login-title-text">بوابة الموظف</h1>
            <div className="login-subtitle-text">للإستعلام عن تفاصيل الأجور الشهرية</div>
          </div>
          
          {submitError && (
            <div className="error-message" style={{
              color: 'red',
              backgroundColor: '#ffe6e6',
              padding: '10px',
              borderRadius: '5px',
              marginBottom: '15px',
              textAlign: 'center',
              fontSize: '14px'
            }}>
              {submitError}
            </div>
          )}
          
          <form className="login-form" autoComplete="off" onSubmit={handleSubmit}>
            <div style={{ position: 'relative', marginBottom: '15px' }}>
              <input
                type="email"
                name="email"
                className={`login-input ${errors.email && touched.email ? 'error-input' : ''}`}
                placeholder="البريد الإلكتروني"
                dir="rtl"
                value={formData.email}
                onChange={handleInputChange}
                onBlur={handleInputBlur}
                onClick={handleInputClick}
                required
                style={{
                  borderColor: errors.email && touched.email ? 'red' : '',
                  borderWidth: errors.email && touched.email ? '2px' : '1px'
                }}
              />
              {errors.email && touched.email && (
                <div style={{
                  color: 'red',
                  fontSize: '12px',
                  marginTop: '5px',
                  textAlign: 'right',
                  fontWeight: 'bold'
                }}>
                  {errors.email}
                </div>
              )}
            </div>

            <div style={{ position: 'relative', marginBottom: '15px' }}>
              <input
                type="password"
                name="password"
                className={`login-input ${errors.password && touched.password ? 'error-input' : ''}`}
                placeholder="كلمة المرور"
                dir="rtl"
                value={formData.password}
                onChange={handleInputChange}
                onBlur={handleInputBlur}
                onClick={handleInputClick}
                required
                style={{
                  borderColor: errors.password && touched.password ? 'red' : '',
                  borderWidth: errors.password && touched.password ? '2px' : '1px'
                }}
              />
              {errors.password && touched.password && (
                <div style={{
                  color: 'red',
                  fontSize: '12px',
                  marginTop: '5px',
                  textAlign: 'right',
                  fontWeight: 'bold'
                }}>
                  {errors.password}
                </div>
              )}
            </div>

            <div className="login-links-row">
              <a href="/resetpassword" className="login-link">نسيت كلمة السر ؟</a>
              <a href="#" className="login-link">إعادة إرسال بريد التحقق</a>
            </div>
            
            <button 
              type="submit" 
              className="login-btn"
              disabled={loading}
            >
              {loading ? 'جاري تسجيل الدخول...' : 'تسجيل الدخول'}
            </button>
            
            <button type="button" className="login-register-btn">لا تملك حساب !</button>
          </form>
          
          <div className="login-lang-row-custom">
            <span className="choose-lang-text">إختر اللغة</span>
            <div className="lang-option">
              <span className="lang-radio checked" />
              <img src={EgyptFlag} alt="Egypt flag" className="lang-flag" />
              <span className="lang-label-text" style={{color: '#002e6d', fontWeight: 'bold'}}>اللغة العربية</span>
            </div>
            <div className="lang-option">
              <span className="lang-radio" />
              <img src={UKFlag} alt="UK flag" className="lang-flag" />
              <span className="lang-label-text" style={{color: '#828282', fontWeight: 'bold'}}>اللغة الإنجليزية</span>
            </div>
          </div>
        </div>
      </div>
      <div className="login-footer-absolute-container">
        <div className="login-footer-text-with-logo">
          <img src={eTaxLogo} alt="eTax logo" className="login-etax-logo" />
          <span className="login-footer-text">جميع الحقوق محفوظة . مدعوم من</span>
        </div>
      </div>
    </div>
  );
};

export default Login; 