import React from "react";
import "./App.css";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import LoginPage from "./pages/auth/LoginPage";
import RegisterPage from "./pages/auth/RegisterPage";
import ForgotPasswordPage from "./pages/auth/ForgotPasswordPage";
import LayoutMainPage from "./pages/layout/LayoutMainPage";
import NotfoundPage from "./pages/notfound/NotfoundPage";

const App: React.FC = () => {
  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<LayoutMainPage/>}>

          </Route>
          <Route path="/auth">
            <Route path="login" element={<LoginPage />} />
            <Route path="register" element={<RegisterPage />} />
            <Route path="recovery" element={<ForgotPasswordPage />} />
          </Route>
          <Route>
            <Route path="*" element={<NotfoundPage/>}></Route>
          </Route>
        </Routes>
      </BrowserRouter>
    </>
  );
};

export default App;
