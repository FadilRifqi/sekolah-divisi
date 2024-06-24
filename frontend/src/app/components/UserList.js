// components/UserList.js

import { useState, useEffect } from "react";
import axiosInstance from "../utils/axios";

const UserList = () => {
  const [data, setData] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axiosInstance.get(
          `http://127.0.0.1:8000/api/user`,
          {
            headers: {
              "Cache-Control": "no-cache",
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        );
        setData(response.data);
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };

    fetchData();
  }, []);

  return (
    <div>
      <h2>User List</h2>
      <ul>
        {data.map((user) => (
          <li key={user.email}>{user.name}</li>
        ))}
      </ul>
    </div>
  );
};

export default UserList;