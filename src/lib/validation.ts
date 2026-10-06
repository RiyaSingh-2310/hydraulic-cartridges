export const NAME_MIN = 2
export const NAME_MAX = 35

export interface QuoteFormValues {
  name: string
  company: string
  email: string
  phone: string
  country: string
  product: string
  quantity: string
  application: string
  message: string
}

export type QuoteFormErrors = Partial<Record<keyof QuoteFormValues, string>>

export interface ContactFormValues {
  name: string
  email: string
  message: string
}

export type ContactFormErrors = Partial<Record<keyof ContactFormValues, string>>

const emailPattern =
  /^[A-Za-z0-9.!#$%&'*+/=?^_`{|}~-]+@[A-Za-z0-9](?:[A-Za-z0-9-]{0,61}[A-Za-z0-9])?(?:\.[A-Za-z0-9](?:[A-Za-z0-9-]{0,61}[A-Za-z0-9])?)+$/

export function validateName(raw: string): string | undefined {
  const name = raw.trim()
  if (name.length < NAME_MIN || name.length > NAME_MAX) {
    return 'Name must be between 2 and 35 characters.'
  }
  return undefined
}

export function validateEmail(raw: string): string | undefined {
  const email = raw.trim()
  if (!email || email.includes('..') || !emailPattern.test(email)) {
    return 'Please enter a valid email address.'
  }
  return undefined
}

export function hasMeaningfulText(raw: string): boolean {
  return raw.trim().length >= 1
}

export function validateQuoteForm(values: QuoteFormValues): QuoteFormErrors {
  const errors: QuoteFormErrors = {}
  const nameError = validateName(values.name)
  const emailError = validateEmail(values.email)

  if (nameError) errors.name = nameError
  if (!values.company.trim()) errors.company = 'Enter your company.'
  if (emailError) errors.email = emailError
  if (!values.phone.trim()) errors.phone = 'Enter a phone number.'
  if (!values.country.trim()) errors.country = 'Enter a country.'
  if (!values.product.trim()) errors.product = 'Select a product or category.'
  if (!values.quantity.trim()) errors.quantity = 'Enter an estimated quantity.'
  if (!values.application.trim()) errors.application = 'Describe the application.'
  if (!hasMeaningfulText(values.message)) {
    errors.message = 'Add a short technical note.'
  }

  return errors
}

export function validateContactForm(values: ContactFormValues): ContactFormErrors {
  const errors: ContactFormErrors = {}
  const nameError = validateName(values.name)
  const emailError = validateEmail(values.email)

  if (nameError) errors.name = nameError
  if (emailError) errors.email = emailError
  if (!hasMeaningfulText(values.message)) {
    errors.message = 'Please enter a message.'
  }

  return errors
}

export const emptyQuoteForm: QuoteFormValues = {
  name: '',
  company: '',
  email: '',
  phone: '',
  country: '',
  product: '',
  quantity: '',
  application: '',
  message: '',
}

export const emptyContactForm: ContactFormValues = {
  name: '',
  email: '',
  message: '',
}
