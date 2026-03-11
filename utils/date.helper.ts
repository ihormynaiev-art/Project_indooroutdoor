export function formatDateToISO(date: Date): string {
    return date.toISOString().split('T')[0];
}

export function getCurrentDateFormatted(): string {
    return formatDateToISO(new Date());
}

export function addDaysToDate(date: Date, numberOfDays: number): Date {
    const resultDate = new Date(date);
    resultDate.setDate(resultDate.getDate() + numberOfDays);
    return resultDate;
}
