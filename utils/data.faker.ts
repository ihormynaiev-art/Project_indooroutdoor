export function generateRandomEmail(): string {
    const timestamp = Date.now();
    const randomSuffix = Math.random().toString(36).substring(2, 8);
    return `test_user_${timestamp}_${randomSuffix}@test.com`;
}

export function generateRandomName(): string {
    const firstNames = ['John', 'Jane', 'Alex', 'Maria', 'David', 'Sarah', 'Michael', 'Emily'];
    const lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis'];
    const randomFirstName = firstNames[Math.floor(Math.random() * firstNames.length)];
    const randomLastName = lastNames[Math.floor(Math.random() * lastNames.length)];
    return `${randomFirstName} ${randomLastName}`;
}

export function generateRandomPhoneNumber(): string {
    const areaCode = Math.floor(Math.random() * 900 + 100);
    const centralOfficeCode = Math.floor(Math.random() * 900 + 100);
    const subscriberNumber = Math.floor(Math.random() * 9000 + 1000);
    return `(${areaCode}) ${centralOfficeCode}-${subscriberNumber}`;
}
