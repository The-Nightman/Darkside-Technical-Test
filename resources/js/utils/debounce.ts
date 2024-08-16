/**
 * Debounces a function to be executed after a specified wait time.
 * @param {function(string): void} fn - The function to be debounced.
 * @param {number} [wait=500] - The wait time in milliseconds (default: 500).
 * @returns {function(...[*]): void} A debounced function.
 */
const useDebounce = (
  fn: { (value: string): void; apply?: any },
  wait: number | undefined = 500
): ((this: any, ...args: any[]) => void) => {
  let timer: number;
  return function (this: any, ...args: any[]) {
    if (timer) {
      clearTimeout(timer);
    }
    const context = this;
    timer = setTimeout(() => {
      fn.apply(context, args);
    }, wait);
  };
};

export default useDebounce;
