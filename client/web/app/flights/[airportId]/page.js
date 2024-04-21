"use client";
import { GlobalContext } from "@/app/context/GlobalContext";
import axios from "axios";
import React, { useContext, useEffect, useState } from "react";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { Navbar } from "@/components/navbar";
import { toast } from "@/components/ui/use-toast";
import { Toaster } from "@/components/ui/toaster";
import { DialogClose } from "@radix-ui/react-dialog";

const page = ({ params }) => {
  const { airportId } = params;
  const { token } = useContext(GlobalContext);
  const [flights, setFlights] = useState([]);
  const [loading, setLoading] = useState(true);
  const [selectedSeat, setSelectedSeat] = useState("");
  // ! can't set token globally
  useEffect(() => {
    const fetchAirports = async () => {
      const resp = await axios.get(
        `${process.env.NEXT_PUBLIC_DOMAIN_NAME}/api/flights/${airportId}`,
        { Authorization: `Bearer ${token}` }
      );
      console.log(resp.data.flights);
      setFlights(resp.data.flights);
      setLoading(false);
    };
    if (token) {
      fetchAirports();
    }
  }, [token]);
  // * flights page
  const generateSeatOptions = (capacity) => {
    const rows = ["A", "B", "C", "D", "E", "F"];
    const seatsPerRow = Math.ceil(capacity / rows.length);
    const seatOptions = [];

    for (let i = 1; i <= seatsPerRow; i++) {
      rows.forEach((row) => {
        if (seatOptions.length < capacity) {
          seatOptions.push(`${row}${i}`);
        }
      });
    }
    return seatOptions.sort((a, b) => {
      const rowA = a.charAt(0);
      const rowB = b.charAt(0);
      const numA = parseInt(a.slice(1), 10);
      const numB = parseInt(b.slice(1), 10);

      if (rowA !== rowB) {
        return rowA.localeCompare(rowB);
      }

      return numA - numB;
    });
  };
  const book = async (flight_id) => {
    try {
      if (selectedSeat != "") {
        const resp = await axios.post(
          `${process.env.NEXT_PUBLIC_DOMAIN_NAME}/api/create-ticket`,
          { flight_id: flight_id, seat: selectedSeat },
          { Authorization: `Bearer ${token}` }
        );
        toast({
          title: "ticket booked!",
        });
        console.log(resp);
      }
    } catch (err) {
      toast({
        title: err.response.data[0],
        variant: "destructive",
      });
    }
  };

  return (
    <div className="">
      <Toaster />
      <Navbar />
      <div className="h-screen flex flex-col justify-center items-center">
        <div className="flex flex-col space-y-5">
          <h2 className="text-3xl">Choose your flight</h2>
          <div className="flights-container flex flex-col space-y-10">
            {flights.map((flight) => (
              <div className="flex flex-col space-y-2">
                <p>From {flight.departure_airport_name}</p>
                <p>To {flight.destination_airport_name}</p>
                <p>Departure {flight.flight_destination}</p>
                <p>Arrival {flight.flight_arrival}</p>
                <p>Plane {flight.plane_name}</p>

                <Dialog>
                  <DialogTrigger
                    onClick={() => setSelectedSeat("")}
                    className="bg-black text-white rounded-lg p-1"
                  >
                    Book
                  </DialogTrigger>
                  <DialogContent>
                    <DialogHeader>
                      <DialogTitle>Flight {flight.flight_id}</DialogTitle>
                      <DialogDescription>
                        Select your seat and book the flight
                      </DialogDescription>
                    </DialogHeader>
                    <label htmlFor="seat">Seat</label>
                    <select
                      id="seat"
                      className="block w-full p-2 mt-2 border rounded-md"
                      value={selectedSeat}
                      onChange={(e) => setSelectedSeat(e.target.value)}
                    >
                      <option value="" disabled>
                        Select a seat
                      </option>
                      {generateSeatOptions(flight.capacity).map((seat) => (
                        <option key={seat} value={seat}>
                          {seat}
                        </option>
                      ))}
                    </select>
                    <DialogClose
                      onClick={() => book(flight.flight_id)}
                      className="bg-black text-white rounded-lg p-1"
                    >
                      Book
                    </DialogClose>
                  </DialogContent>
                </Dialog>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default page;
