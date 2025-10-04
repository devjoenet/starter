export function getCopyright(): string {
  return "Joe Harris • © " + new Date().getFullYear();
}
export function useCopyright(): string {
  return getCopyright();
}
