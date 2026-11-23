/*
 * Small C companion report: reads the CSV exported by export_assets.php.
 * Usage: gcc report.c -o report && report.exe assets-export.csv
 * Note: this simple teaching example expects plain CSV fields without embedded commas.
 */
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main(int argc, char *argv[]) {
    if (argc < 2) {
        printf("Usage: %s assets-export.csv\n", argv[0]);
        return 1;
    }
    FILE *fp = fopen(argv[1], "r");
    if (!fp) { perror("Could not open CSV"); return 1; }

    char line[2048];
    int total = 0, available = 0, assigned = 0, maintenance = 0, retired = 0;
    double total_value = 0.0;
    if (fgets(line, sizeof(line), fp) == NULL) { fclose(fp); return 0; }

    while (fgets(line, sizeof(line), fp)) {
        char *fields[8] = {0};
        int n = 0;
        char *token = strtok(line, ",\r\n");
        while (token && n < 8) { fields[n++] = token; token = strtok(NULL, ",\r\n"); }
        if (n < 8) continue;
        total++;
        total_value += atof(fields[5]);
        if (strcmp(fields[7], "Available") == 0) available++;
        else if (strcmp(fields[7], "Assigned") == 0) assigned++;
        else if (strcmp(fields[7], "Under Maintenance") == 0) maintenance++;
        else if (strcmp(fields[7], "Retired") == 0) retired++;
    }
    fclose(fp);
    printf("IT ASSET SUMMARY\n----------------\n");
    printf("Total assets: %d\nAvailable: %d\nAssigned: %d\nUnder maintenance: %d\nRetired: %d\n",
           total, available, assigned, maintenance, retired);
    printf("Total purchase value: %.2f\n", total_value);
    return 0;
}
