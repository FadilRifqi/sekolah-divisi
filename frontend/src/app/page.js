"use client";
import styles from "./page.module.css";
import UserList from "./components/UserList";

export default function Home() {
  return (
    <main className={styles.main}>
      <div className={styles.description}>
        <UserList />
      </div>
    </main>
  );
}
