import React from "react";

const page = ({ params }) => {
  const { airportId } = params;
  return <div>{airportId}</div>;
};

export default page;
