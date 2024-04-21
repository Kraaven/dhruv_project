"use client";
import React, { useContext, useEffect, useState } from "react";
import { GlobalContext } from "../context/GlobalContext";
import axios from "axios";
import Link from "next/link";

const Page = () => {
  const { name, token } = useContext(GlobalContext);
  const [airports, setAirports] = useState([]);
  const [loading, setLoading] = useState(true);
  // ! can't set token globally
  useEffect(() => {
    const fetchAirports = async () => {
      const resp = await axios.get(
        `${process.env.NEXT_PUBLIC_DOMAIN_NAME}/api/airports`,
        { Authorization: `Bearer ${token}` }
      );
      console.log(resp.data.airports);
      setAirports(resp.data.airports);
      setLoading(false);
    };
    if (token) {
      fetchAirports();
    }
  }, [token]);
  // * airports page
  return (
    <div className="h-screen bg-red-400 flex flex-col justify-center items-center">
      <div className="flex flex-col items-center space-y-5 w-full">
        <div className="">
          <div className="text-start text-3xl">Hello {name}</div>
          <div className="text-start text-2xl">Choose your airport</div>
        </div>
        <div className="airport-container flex flex-col space-y-4 w-[30%] text-center">
          {!loading ? (
            <>
              {airports.map((airport) => (
                <Link
                  className="text-center bg-blue-200 border-black border rounded-lg"
                  href={`flights/${airport.id}`}
                >
                  <p className="text-xl">{airport.name}</p>
                  <p>Flight Count: {airport.flight_count}</p>
                </Link>
              ))}
            </>
          ) : (
            <>loading...</>
          )}
        </div>
      </div>
    </div>
  );
};

export default Page;
