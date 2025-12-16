import type { ClassValue } from "clsx"
import { clsx } from "clsx"
import { twMerge } from "tailwind-merge"

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

export function getCookie(name: string): string {
    if (document.cookie) {
        const cookie = `; ${document.cookie}`;
        const parts = cookie.split(`; ${name}=`);
        if (parts.length === 2) return decodeURIComponent(parts.pop()!.split(';').shift()!);
    }
    
    return "";
}

export function formatDate(strDate: string): string {
    const date = new Date(strDate);

    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long', // optional: adds the day of the week
    }).format(date)
}

export function isDateToday(dateString: string): boolean {
    const today = new Date();
    const inputDate = new Date(dateString);

    // Set the time of both dates to midnight to ignore time differences
    today.setHours(0, 0, 0, 0);
    inputDate.setHours(0, 0, 0, 0);

    // Compare the dates
    return today.getTime() === inputDate.getTime();
}