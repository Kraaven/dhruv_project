"use client";
import React, { useState, useEffect } from "react";
import { GlobalContext } from "./GlobalContext";
import axios from "axios";

export const GlobalState = ({ children }) => {
  const [email, setEmail] = useState("");
  const [name, setName] = useState("");
  const [token, setToken] = useState("");

  useEffect(() => {
    const callUserData = async () => {
      try {
        const url = `${process.env.NEXT_PUBLIC_DOMAIN_NAME}/api/user-data`;
        const resp = await axios.get(url, { withCredentials: true });
        console.log(resp);
        if (resp.data.access_token) {
          axios.defaults.headers.common[
            "Authorization"
          ] = `Bearer ${resp.data.access_token}`;
          setEmail(resp.data.email);
          setToken(resp.data.access_token);
          setName(resp.data.name);
        }
      } catch (error) {
        console.log(error);
      }
    };
    callUserData();
  }, []);
  const globalStateValue = {
    email: email,
    name: name,
    token: token,
  };
  return (
    <GlobalContext.Provider value={globalStateValue}>
      {children}
    </GlobalContext.Provider>
  );
};
