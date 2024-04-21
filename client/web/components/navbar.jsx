import Link from "next/link";
import React from "react";

export const Navbar = () => {
  return (
    <div className="flex justify-between w-full h-16 items-center bg-black px-5 text-white">
      <div className="text-2xl">Icarus</div>
      <div className="navlinks">
        <Link href={"/main"}>Airports</Link>
      </div>
    </div>
  );
};
